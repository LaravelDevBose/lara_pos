<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\Tax;
use App\Traits\ResponseTrait;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Exception;

class TaxController extends Controller
{
    public function index(Request $request)
    {
        $taxes = Tax::query()->notDelete()->searchBy($request)->latest()->paginate(20);
        return view('modules.setting.tax.index',compact('taxes'));
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
            'tax_title' => ['required','string', 'unique:taxes,tax_title'],
            'tax_percent' => ['required','string'],
        ],[
            'tax_title.required'=> 'Tax name is Required',
            'tax_percent.string'=> 'Tax percent is Required',
            'tax_title.unique'=> 'Tax is Already Added',
        ]);
        if ($validator->passes()) {
            try {
                DB::beginTransaction();
                $tax = Tax::create([
                    'tax_title' => $request->tax_title,
                    'tax_percent' => $request->tax_percent,
                    'status' => !empty($request->get('status')) ? $request->status : config('constant.inactive')
                ]);
                if (!empty($tax)) {
                    DB::commit();
                    return ResponseTrait::AllResponse('success', Response::HTTP_OK, 'Tax Created Successfully', route('taxes.index'));
                }
                throw new \Exception('Invalid Tax Information');
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
        $tax = Tax::findOrFail($id);
        $taxes = Tax::query()->notDelete()->latest()->paginate(20);
        return view('modules.setting.tax.index', compact('tax', 'taxes'));
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
            'tax_title' => ['required', 'string',Rule::unique('taxes', 'tax_title')->ignore($id,'tax_id')],
        ],[
            'tax_title.required'=> 'Tax name is Required',
            'tax_percent.string'=> 'Tax percent is Required',
            'tax_title.unique'=> 'Tax is Already Added',
        ]);
        if ($validator->passes()) {
            try {
                DB::beginTransaction();
                $tax = Tax::find($id);
                if (empty($tax)) {
                    throw new \Exception('Invalid Tax Information');
                }
                $taxU = $tax->update([
                    'tax_title' => $request->tax_title,
                    'tax_percent' => $request->tax_percent,
                    'status' => !empty($request->get('status')) ? $request->status : config('constant.inactive')
                ]);
 
                if (!empty($taxU)) {
                    DB::commit();
                    return ResponseTrait::AllResponse('success', Response::HTTP_OK, 'Tax Updated Successfully', route('taxes.index'));
                }
                throw new \Exception('Invalid Tax Information');
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
            $tax = Tax::find($id);
            if (empty($tax)){
                throw new \Exception('Invalid Tax Information',Response::HTTP_NOT_FOUND);
            }
            if(Tax::find($id)->delete()){
                DB::commit();
                return ResponseTrait::AllResponse('success', Response::HTTP_OK, 'Tax Deleted Successfully', route('taxes.index'));
            }
            throw new \Exception('Invalid Tax Information',Response::HTTP_NOT_FOUND);
        }catch(Exception $ex){
            DB::rollBack();
            return ResponseTrait::AllResponse('error', Response::HTTP_BAD_REQUEST, $ex->getMessage());
        }
    }
}
