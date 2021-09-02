<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use Exception;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        return view('modules.contact.index');
    }

    public function datatable(Request $request)
    {
        $dataTable = Contact::query()->notDelete()->searchBy($request)->latest();

        return DataTables::of($dataTable)
            ->addColumn('advance_balance', function ($data){
                return '0.00';
            })
            ->editColumn('total_due', function ($data){
                return '0.00';
            })
            ->addColumn('status', function($data){
                return ($data->status == 1)? '<span class="badge badge-success badge-md">Active</span>':' <span class="badge badge-warning badge-md">Inactive</span>';
            })
            ->addColumn('checkbox', function($data){
                return '<div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="contact_ids[]" value="'.$data->contact_id.'" id="checkboxsmall1">
                            <label class="custom-control-label" for="checkboxsmall1"></label>
                        </div>';
            })
            ->addColumn('action',function($data){
                $actionButton = '<span class="dropdown">
                                    <a id="btnSearchDrop2" href="#" title="Action" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="dropdown-toggle dropdown-menu-right btn btn-info btn-sm"><i class="la la-cogs"></i></a>
                                    <span aria-labelledby="btnSearchDrop2" class="dropdown-menu mt-1 dropdown-menu-right">';
                $actionButton .= '<a  href="' . route('contacts.edit', $data->contact_id) . '"  title="Edit" class="dropdown-item"><i class="ft-edit-2"></i> Edit </a>';
                $actionButton .= '</span></span>';
                return $actionButton;
            })->rawColumns(['status', 'checkbox','action'])->make(true);

    }

    public function create(Request $request)
    {
        $code = Contact::getCode($request->type);
        return view('modules.contact.create_update', compact('code'));
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
            'first_name' => ['required','string'],
            'mobile_no' => ['required','unique:contacts,mobile_no'],
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
                $contact = Contact::create([
                    'unique_code' => !empty($request->unique_code)? $request->unique_code: Contact::getCode($request->contact_type),
                    'contact_type' => !empty($request->contact_type)? $request->contact_type: 'customer',
                    'first_name' =>  $request->first_name,
                    'last_name' => !empty($request->last_name)? $request->last_name: null,
                    'business_name' => !empty($request->business_name)? $request->business_name: null,
                    'mobile_no' => $request->mobile_no,
                    'alt_phone_no' => !empty($request->alt_phone_no)? $request->alt_phone_no: null,
                    'email' => !empty($request->email)? $request->email: null,
                    'contact_dob' => !empty($request->contact_dob)? Carbon::parse($request->contact_dob)->format('Y-m-d'): null,
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
                if (!empty($contact)) {
                    DB::commit();
                    return ResponseTrait::AllResponse('success', Response::HTTP_OK, 'Contact Created Successfully', route('contacts.index', ['type'=>$request->contact_type]));
                }
                throw new \Exception('Invalid Contact Information');
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
        $contact = Contact::findOrFail($id);
        return view('modules.contact.create_update', compact('contact'));
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
            'mobile_no' => ['required',Rule::unique('contacts', 'mobile_no')->ignore($id,'contact_id')],
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
                $contact = Contact::find($id);
                if (empty($contact)) {
                    throw new \Exception('Invalid Contact Information');
                }
                $contactU = $contact->update([
                    'first_name' =>  $request->first_name,
                    'last_name' => !empty($request->last_name)? $request->last_name: null,
                    'business_name' => !empty($request->business_name)? $request->business_name: null,
                    'mobile_no' => $request->mobile_no,
                    'alt_phone_no' => !empty($request->alt_phone_no)? $request->alt_phone_no: null,
                    'email' => !empty($request->email)? $request->email: null,
                    'contact_dob' => !empty($request->contact_dob)? Carbon::parse($request->contact_dob)->format('Y-m-d'): null,
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

                if (!empty($contactU)) {
                    DB::commit();
                    return ResponseTrait::AllResponse('success', Response::HTTP_OK, 'Contact Updated Successfully', route('contacts.index', ['type'=>$request->contact_type]));
                }
                throw new \Exception('Invalid Contact Information');
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
            $contact = Contact::find($id);
            if (empty($contact)){
                throw new \Exception('Invalid Contact Information',Response::HTTP_NOT_FOUND);
            }
            $type = $contact->contact_type;
            if(Contact::find($id)->delete()){
                DB::commit();
                return ResponseTrait::AllResponse('success', Response::HTTP_OK, 'Contact Deleted Successfully', route('contact.index', ['type'=>$type]));
            }
            throw new \Exception('Invalid Contact Information',Response::HTTP_NOT_FOUND);
        }catch(Exception $ex){
            DB::rollBack();
            return ResponseTrait::AllResponse('error', Response::HTTP_BAD_REQUEST, $ex->getMessage());
        }
    }
    //supplier and customer information show for purchase and sell page
    public function details($id)
    {
        $details = Contact::query()->Details($id);
        return response()->json($details, 200);
    }
}
