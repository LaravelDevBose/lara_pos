<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use App\Traits\ResponseTrait;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Exception;

class UnitController extends Controller
{
    public function index(Request $request)
    {
        $units = Unit::query()->notDelete()->searchBy($request)->latest()->paginate(20);
        return view('modules.setting.unit.index',compact('units'));
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
            'unit_name' => ['required','string', 'unique:units,unit_name'],
            'sort_form' => ['required','string'],
        ],[
            'unit_name.required'=> 'Unit Name is Required',
            'sort_form.string'=> 'Sort From is Required',
            'unit_name.unique'=> 'unit Name is Already Added',
        ]);
        if ($validator->passes()) {
            try {
                DB::beginTransaction();
                $unit = Unit::create([
                    'unit_name' => $request->unit_name,
                    'sort_form' => $request->sort_form,
                    'status' => !empty($request->get('status')) ? $request->status : config('constant.inactive')
                ]);
                if (!empty($unit)) {
                    DB::commit();
                    return ResponseTrait::AllResponse('success', Response::HTTP_OK, 'unit Created Successfully', route('units.index'));
                }
                throw new \Exception('Invalid unit Information');
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
        $unit = Unit::findOrFail($id);
        $units = Unit::query()->notDelete()->latest()->paginate(20);
        return view('modules.setting.unit.index', compact('unit', 'units'));
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
            'unit_name' => ['required', 'string',Rule::unique('units', 'unit_name')->ignore($id,'unit_id')],
        ],[
            'unit_name.required'=> 'Unit Name is Required',
            'sort_form.string'=> 'Sort Form is Required',
            'unit_name.unique'=> 'Unit Name is Already Added',
        ]);
        if ($validator->passes()) {
            try {
                DB::beginTransaction();
                $unit = Unit::find($id);
                if (empty($unit)) {
                    throw new \Exception('Invalid unit Information');
                }
                $unitU = $unit->update([
                    'unit_name' => $request->unit_name,
                    'sort_form' => $request->sort_form,
                    'status' => !empty($request->get('status')) ? $request->status : config('constant.inactive')
                ]);

                if (!empty($unitU)) {
                    DB::commit();
                    return ResponseTrait::AllResponse('success', Response::HTTP_OK, 'unit Updated Successfully', route('units.index'));
                }
                throw new \Exception('Invalid unit Information');
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
            $unit = Unit::find($id);
            if (empty($unit)){
                throw new \Exception('Invalid unit Information',Response::HTTP_NOT_FOUND);
            }
            if(Unit::find($id)->delete()){
                DB::commit();
                return ResponseTrait::AllResponse('success', Response::HTTP_OK, 'Unit Deleted Successfully', route('units.index'));
            }
            throw new \Exception('Invalid unit Information',Response::HTTP_NOT_FOUND);
        }catch(Exception $ex){
            DB::rollBack();
            return ResponseTrait::AllResponse('error', Response::HTTP_BAD_REQUEST, $ex->getMessage());
        }
    }
}
