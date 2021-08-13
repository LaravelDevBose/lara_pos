<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BankAccountController extends Controller
{
    public function index(Request $request)
    {
        $accounts = BankAccount::notDelete()->latest()->get();
        return view('modules.bank_account.index',compact('accounts'));
    }

    public function create(Request $request)
    {
        $accountTypes = array_flip(BankAccount::AccountTypes);
        return view('modules.bank_account.create_update', compact('accountTypes'));
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
            'acc_holder_name' => ['required','string'],
            'account_number' => ['required','string'],
            'account_type' => ['required'],
            'opening_balance' => ['required'],
        ],[
            'acc_holder_name.required'=> 'Account holder name is required',
            'acc_holder_name.string'=> 'Account holder name Must be string',
            'account_number.required'=> 'Account number is required',
            'account_number.string'=> 'Account number Must be string',
            'account_type.required'=> 'Account type is required',
            'opening_balance.required'=> 'Opening balance is required',
        ]);
        if ($validator->passes()) {
            try {
                DB::beginTransaction();
                $account = BankAccount::create([
                    'acc_holder_name' => $request->acc_holder_name,
                    'account_number' => $request->account_number,
                    'account_type' => $request->account_type,
                    'opening_balance' => $request->opening_balance,
                    'account_details' => !empty($request->account_details)? json_encode($request->account_details, true) : null,
                    'account_note' => !empty($request->account_note)? $request->account_note : null,
                    'status' => !empty($request->get('status')) ? $request->status : config('constant.inactive')
                ]);
                if (!empty($account)) {
                    DB::commit();
                    return ResponseTrait::AllResponse('success', Response::HTTP_OK, 'Account Created Successfully', route('bank_accounts.index'));
                }
                throw new \Exception('Invalid Account Information');
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
        $account = BankAccount::findOrFail($id);
        $accountTypes = array_flip(BankAccount::AccountTypes);
        return view('modules.bank_account.create_update', compact('account', 'accountTypes'));
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
            'acc_holder_name' => ['required','string'],
            'account_number' => ['required','string'],
            'account_type' => ['required'],
            'opening_balance' => ['required'],
        ],[
            'acc_holder_name.required'=> 'Account holder name is required',
            'acc_holder_name.string'=> 'Account holder name Must be string',
            'account_number.required'=> 'Account number is required',
            'account_number.string'=> 'Account number Must be string',
            'account_type.required'=> 'Account type is required',
            'opening_balance.required'=> 'Opening balance is required',
        ]);
        if ($validator->passes()) {
            try {
                DB::beginTransaction();
                $account = BankAccount::find($id);
                if (empty($account)) {
                    throw new \Exception('Invalid Account Information');
                }
                $accountU = $account->update([
                    'acc_holder_name' => $request->acc_holder_name,
                    'account_number' => $request->account_number,
                    'account_type' => $request->account_type,
                    'opening_balance' => $request->opening_balance,
                    'account_details' => !empty($request->account_details)? json_encode($request->account_details, true) : null,
                    'account_note' => !empty($request->account_note)? $request->account_note : null,
                    'status' => !empty($request->get('status')) ? $request->status : config('constant.inactive')
                ]);

                if (!empty($accountU)) {
                    DB::commit();
                    return ResponseTrait::AllResponse('success', Response::HTTP_OK, 'Account Updated Successfully', route('bank_accounts.index'));
                }
                throw new \Exception('Invalid Account Information');
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
            $account = BankAccount::find($id);
            if (empty($account)){
                throw new \Exception('Invalid Account Information',Response::HTTP_NOT_FOUND);
            }
            if(BankAccount::find($id)->delete()){
                DB::commit();
                return ResponseTrait::AllResponse('success', Response::HTTP_OK, 'Account Deleted Successfully', route('accounts.index'));
            }
            throw new \Exception('Invalid BankAccount Information',Response::HTTP_NOT_FOUND);
        }catch(\Exception $ex){
            DB::rollBack();
            return ResponseTrait::AllResponse('error', Response::HTTP_BAD_REQUEST, $ex->getMessage());
        }
    }
}
