<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\BusinessLocation;
use App\Models\ExpanseHead;
use App\Models\Expense;
use App\Models\Transaction;
use App\Models\User;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use Exception;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        return view('modules.expense.index');
    }

    public function datatable(Request $request)
    {
        $dataTable = Expense::query()->notDelete()->searchBy($request)
            ->with('head', 'location', 'expense_user')->latest();

        return DataTables::of($dataTable)
            ->editColumn('expense_date', function ($data){
                return Carbon::parse($data->expense_date)->format('m/d/Y');
            })
            ->editColumn('head_id', function ($data){
                return $data->head->head_title;
            })
            ->editColumn('location_id', function ($data){
                return $data->location->store_name;
            })
            ->editColumn('expense_for', function ($data){
                if(!empty($data->expense_user)){
                    return $data->expense_user->name;
                }
                return '';
            })
            ->editColumn('payment_status', function($data){
                if ($data->payment_status == Transaction::PaymentStatus['Paid']){
                    return '<span class="badge badge-success badge-sm">Paid</span>';
                }else if($data->payment_status == Transaction::PaymentStatus['Partial']){
                    return' <span class="badge badge-info badge-sm">Partial</span>';
                }else{
                    return' <span class="badge badge-danger badge-sm">Due</span>';
                }
            })
            ->addColumn('action',function($data){
                $actionButton = '<span class="dropdown">
                                    <a id="btnSearchDrop2" href="#" title="Action" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="dropdown-toggle dropdown-menu-right btn btn-info btn-sm"><i class="la la-cogs"></i></a>
                                    <span aria-labelledby="btnSearchDrop2" class="dropdown-menu mt-1 dropdown-menu-right">';
                $actionButton .= '<a  href="' . route('expenses.edit', $data->expense_id) . '"  title="Edit" class="dropdown-item"><i class="far fa-edit"></i> Edit </a>';
                if ($data->payment_status != Transaction::PaymentStatus['Paid']){
                    $actionButton .= '<a  href="#"  title="Add Payment" class="dropdown-item AddPayment" data-url="'.route('add.transactions', ['id'=>$data->expense_id, 'model'=>Transaction::Models['Expense']]).'"><i class="far fa-money-bill-alt"></i> Add Payment </a>';
                }

                $actionButton .= '<a  href="#"  title="View Payments" class="dropdown-item ViewPayments" data-url="'.route('view.transactions', ['id'=>$data->expense_id, 'model'=>Transaction::Models['Expense']]).'"><i class="far fa-file-invoice-dollar"></i>View Payments  </a>';
                $actionButton .= '</span></span>';
                return $actionButton;
            })->rawColumns(['payment_status', 'checkbox','action'])->make(true);

    }

    public function create(Request $request)
    {
        $code = Expense::getCode();
        $locations = BusinessLocation::latest()->pluck('store_name', 'location_id');
        $heads = ExpanseHead::latest()->pluck('head_title', 'head_id');
        $employees = User::latest()->pluck('name', 'id');
        $paymentMethods = array_flip(Transaction::Methods);
        $bankAccounts = BankAccount::latest()->get()->pluck('account_info', 'bank_acc_id');
        return view('modules.expense.create_update',
            compact('code', 'locations', 'heads', 'employees', 'paymentMethods', 'bankAccounts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'location_id' => ['required'],
            'reference_no' => ['required', 'string','unique:expenses,reference_no'],
            'expense_date' => ['required'],
            'head_id' => ['required'],
            'total_amount' => ['required','numeric', 'min:0', 'not_in:0'],
            'paid_amount' => ['required', 'numeric'],
            'paid_on' => ['required'],
            'payment_method' => ['required', Rule::in(Transaction::Methods)],
            'attachment'=> ['nullable','file', 'max:1024', 'mimes:jpeg,jpg,png,pdf,doc,csv,docx']
        ],[
            'location_id.required'=> 'Business Location is Required',
            'reference_no.required'=> 'Reference no. is Required',
            'reference_no.string'=> 'Reference no. Must be String',
            'reference_no.unique'=> 'Reference no. is Already Added. Must be Unique',
            'expense_date.required'=> 'Expense Date. is Required',
            'head_id.required'=> 'Expense Head is Required',
            'total_amount.required'=> 'Total Amount is Required',
            'total_amount.numeric'=> 'Total Amount must be Numeric',
            'total_amount.min'=> 'Total Amount is more then Zero',
            'total_amount.not_in'=> 'Please Provide Valid total Amount',
            'paid_amount.required'=> 'Paid Amount is Required',
            'paid_amount.numeric'=> 'Paid Amount must be numeric',
            'paid_on.required'=> 'Paid on Date is Required',
            'payment_method.required'=> 'Payment Method is Required',
            'attachment.max'=> 'Attachment is max 1MB',
            'attachment.mimes'=> 'Attachment Allowed File: .pdf, .csv, .doc, .docx, .jpeg, .jpg, .png',
        ]);
        if ($validator->passes()) {
            try {
                DB::beginTransaction();
                $paymentStatus = ($request->total_amount == $request->paid_amount)? Transaction::PaymentStatus['Paid'] :(($request->paid_amount == 0)? Transaction::PaymentStatus['Due']: Transaction::PaymentStatus['Partial']);
                $expense = Expense::create([
                    'location_id' => $request->location_id,
                    'head_id' => $request->head_id,
                    'reference_no' => !empty($request->reference_no)? $request->reference_no: Expense::getCode(),
                    'expense_date' => !empty($request->date)? Carbon::parse($request->date)->format('Y-m-d'): Carbon::now(),
                    'expense_for' => !empty($request->expense_for)? $request->expense_for: null,
                    'total_amount' =>  $request->total_amount,
                    'expense_note' => !empty($request->expense_note)? $request->expense_note: null,
                    'payment_status' => $paymentStatus
                ]);
                if (!empty($expense)) {

                    if (!empty($request->attachment)){
                        $attachment = $expense->singleFileUpload($request->attachment);
                        if (empty($attachment)){
                            throw new Exception('Invalid Attachment File Information');
                        }
                    }
                    if($request->paid_amount > 0){
                        $paid = $expense->storeNewTransaction($request);
                        if (empty($paid)){
                            throw new Exception('Invalid Payment Information');
                        }
                    }
                    DB::commit();
                    return ResponseTrait::AllResponse('success', Response::HTTP_OK, 'Expense Created Successfully', route('expenses.index'));
                }
                throw new \Exception('Invalid Expense Information');
            } catch (\Exception $ex) {
                DB::rollBack();
                return ResponseTrait::AllResponse('error', Response::HTTP_BAD_REQUEST, $ex->getMessage());
            }
        }else{
            return ResponseTrait::ValidationResponse(array_values($validator->errors()->getMessages()), 'validation', Response::HTTP_NOT_ACCEPTABLE);
        }
    }

    public function edit($id)
    {
        $expense = Expense::findOrFail($id);
        return view('modules.expense.create_update', compact('expense'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'first_name' => ['required','string'],
            'mobile_no' => ['required',Rule::unique('expenses', 'mobile_no')->ignore($id,'expense_id')],
            'email' => ['nullable','email'],
        ],[
            'first_name.required'=> 'First name is Required',
            'first_name.string'=> 'First name Must be String',
            'mobile_no.required'=> 'Mobile no. is Required',
            'mobile_no.unique'=> 'Mobile no. is Already Added',
            'email.unique'=> 'Enter a valid email address',
        ]);

        if ($validator->passes()) {
            try {
                DB::beginTransaction();
                $expense = Expense::find($id);
                if (empty($expense)) {
                    throw new \Exception('Invalid Expense Information');
                }
                $expenseU = $expense->update([
                    'first_name' =>  $request->first_name,
                    'last_name' => !empty($request->last_name)? $request->last_name: null,
                    'business_name' => !empty($request->business_name)? $request->business_name: null,
                    'mobile_no' => $request->mobile_no,
                    'alt_phone_no' => !empty($request->alt_phone_no)? $request->alt_phone_no: null,
                    'email' => !empty($request->email)? $request->email: null,
                    'expense_dob' => !empty($request->expense_dob)? Carbon::parse($request->expense_dob)->format('Y-m-d'): null,
                    'open_balance' => !empty($request->open_balance)? $request->open_balance: '0.00',
                    'pay_term_num' => !empty($request->pay_term_num)? $request->pay_term_num: null,
                    'pay_term_type' => !empty($request->pay_term_type)? $request->pay_term_type: null,
                    'credit_limit' => !empty($request->credit_limit)? $request->credit_limit: null,
                    'address_line' => !empty($request->address_line)? $request->address_line: null,
                    'city' => !empty($request->city)? $request->city: null,
                    'state' => !empty($request->state)? $request->state: null,
                    'country' => !empty($request->country)? $request->country: null,
                    'zip_code' => !empty($request->zip_code)? $request->zip_code: null,
                    'status' => !empty($request->get('status')) ? $request->status : config('constant.inactive')
                ]);

                if (!empty($expenseU)) {
                    DB::commit();
                    return ResponseTrait::AllResponse('success', Response::HTTP_OK, 'Expense Updated Successfully', route('expenses.index', ['type'=>$request->expense_type]));
                }
                throw new \Exception('Invalid Expense Information');
            } catch (\Exception $ex) {
                DB::rollBack();
                return ResponseTrait::AllResponse('error', Response::HTTP_BAD_REQUEST, $ex->getMessage());
            }
        }else{
            return ResponseTrait::ValidationResponse(array_values($validator->errors()->getMessages()), 'validation', Response::HTTP_NOT_ACCEPTABLE);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        try{
            $expense = Expense::find($id);
            if (empty($expense)){
                throw new \Exception('Invalid Expense Information',Response::HTTP_NOT_FOUND);
            }
            $type = $expense->expense_type;
            if(Expense::find($id)->delete()){
                DB::commit();
                return ResponseTrait::AllResponse('success', Response::HTTP_OK, 'Expense Deleted Successfully', route('expense.index', ['type'=>$type]));
            }
            throw new \Exception('Invalid Expense Information',Response::HTTP_NOT_FOUND);
        }catch(Exception $ex){
            DB::rollBack();
            return ResponseTrait::AllResponse('error', Response::HTTP_BAD_REQUEST, $ex->getMessage());
        }
    }
}
