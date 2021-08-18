<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\Expense;
use App\Models\Transaction;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TransactionController extends Controller
{
    public function show(Request $request, $id)
    {
        if($request->model == Transaction::Models['Expense']){
            $data = Expense::where('expense_id', $id)->with('head', 'location', 'expense_user', 'transactions.account')->first();
        }
        if(empty($data)){
            $view = view('modal_views.errors.404_error')->render();
        }else{
            $view = view('components.payment.view_payments', compact('data'))->render();
        }

        return ResponseTrait::SingleResponse($view, 'Success', Response::HTTP_OK);
    }

    public function create(Request $request, $id)
    {
        $view = view('modal_views.errors.404_error')->render();
        $paymentMethods = array_flip(Transaction::Methods);
        $bankAccounts = BankAccount::latest()->get()->pluck('account_info', 'bank_acc_id');

        if($request->model == Transaction::Models['Expense']){
            $data = Expense::with('head', 'location', 'expense_user')->find($id);
            if(!empty($data)){
                $due = $data->payment_due;
                $model = Transaction::Models['Expense'];
                $view=  view('components.payment.add_payment', compact('data', 'paymentMethods', 'bankAccounts', 'due', 'id','model'))->render();
            }

        }
        return ResponseTrait::SingleResponse($view, 'Success', Response::HTTP_OK);

    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'paid_amount' => ['required', 'numeric'],
            'paid_on' => ['required'],
            'payment_method' => ['required', Rule::in(Transaction::Methods)]
        ],[
            'paid_amount.required'=> 'Paid Amount is Required',
            'paid_amount.numeric'=> 'Paid Amount must be numeric',
            'paid_on.required'=> 'Paid on Date is Required',
            'payment_method.required'=> 'Payment Method is Required',
        ]);
        if ($validator->passes()) {
            try {
                DB::beginTransaction();
                if($request->model ==Transaction::Models['Expense']){
                    $transactionModel = Expense::find($request->model_id);
                }

                if (empty($transactionModel)) {
                    throw new \Exception('Invalid Transaction Information');
                }

                if($transactionModel->total() == ($transactionModel->paidAmount() + $request->paid_amount)){
                    $status = Transaction::PaymentStatus['Paid'];
                }else{
                    $status = Transaction::PaymentStatus['Partial'];
                }
                $updated = $transactionModel->update([
                    'payment_status'=>$status
                ]);

                if (!empty($updated)) {
                    $newTrans = $transactionModel->storeNewTransaction($request);
                    if(!empty($newTrans)){
                        DB::commit();
                        return ResponseTrait::AllResponse('success', Response::HTTP_OK, 'New Payment added Successfully', '#');
                    }{
                        throw new \Exception('Invalid Transaction Information');
                    }
                }{
                    throw new \Exception('Invalid Transaction Information');
                }

            } catch (\Exception $ex) {
                DB::rollBack();
                return ResponseTrait::AllResponse('error', Response::HTTP_BAD_REQUEST, $ex->getMessage());
            }
        }else {
            return ResponseTrait::ValidationResponse(array_values($validator->errors()->getMessages()), 'validation', Response::HTTP_NOT_ACCEPTABLE);
        }
    }
}
