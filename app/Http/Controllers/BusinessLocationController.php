<?php

namespace App\Http\Controllers;

use App\Models\BusinessLocation;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BusinessLocationController extends Controller
{
    public function index(Request $request)
    {
        $locations = BusinessLocation::notDelete()->latest()->get();
        return view('modules.business_location.index', compact('locations'));
    }

    public function create(Request $request)
    {
        return view('modules.business_location.create_update');
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
            'store_name' => ['required','string'],
            'phone_no' => ['required'],
        ],[
            'store_name.required'=> 'Business name is Required',
            'store_name.string'=> 'Business name Must be String',
            'phone_no.required'=> 'Mobile no. is Required',
        ]);
        if ($validator->passes()) {
            try {
                DB::beginTransaction();
                $location = BusinessLocation::create([
                    'store_name' =>  $request->store_name,
                    'phone_no' => $request->phone_no,
                    'alt_phone_no' => !empty($request->alt_phone_no)? $request->alt_phone_no: null,
                    'landmark' => !empty($request->landmark)? $request->landmark: null,
                    'city' => !empty($request->city)? $request->city: null,
                    'zipcode' => !empty($request->zipcode)? $request->zipcode: null,
                    'state' => !empty($request->state)? $request->state: null,
                    'country' => !empty($request->country)? $request->country: null,
                    'status' => !empty($request->get('status')) ? $request->status : config('constant.inactive')
                ]);
                if (!empty($location)) {
                    DB::commit();
                    return ResponseTrait::AllResponse('success', Response::HTTP_OK, 'Business Location Created Successfully', route('business_locations.index'));
                }
                throw new \Exception('Invalid Business Location Information');
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
        $location = BusinessLocation::findOrFail($id);
        return view('modules.business_location.create_update', compact('location'));
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
            'store_name' => ['required','string'],
            'phone_no' => ['required'],
        ],[
            'store_name.required'=> 'Business name is Required',
            'store_name.string'=> 'Business name Must be String',
            'phone_no.required'=> 'Mobile no. is Required',
        ]);

        if ($validator->passes()) {
            try {
                DB::beginTransaction();
                $location = BusinessLocation::find($id);
                if (empty($location)) {
                    throw new \Exception('Invalid Business Location Information');
                }
                $locationU = $location->update([
                    'store_name' =>  $request->store_name,
                    'phone_no' => $request->phone_no,
                    'alt_phone_no' => !empty($request->alt_phone_no)? $request->alt_phone_no: null,
                    'landmark' => !empty($request->landmark)? $request->landmark: null,
                    'city' => !empty($request->city)? $request->city: null,
                    'zipcode' => !empty($request->zipcode)? $request->zipcode: null,
                    'state' => !empty($request->state)? $request->state: null,
                    'country' => !empty($request->country)? $request->country: null,
                    'status' => !empty($request->get('status')) ? $request->status : config('constant.inactive')
                ]);

                if (!empty($locationU)) {
                    DB::commit();
                    return ResponseTrait::AllResponse('success', Response::HTTP_OK, 'Business Location Updated Successfully', route('business_locations.index'));
                }
                throw new \Exception('Invalid Business Location Information');
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
            $location = BusinessLocation::find($id);
            if (empty($location)){
                throw new \Exception('Invalid Business Location Information',Response::HTTP_NOT_FOUND);
            }
            if(BusinessLocation::find($id)->delete()){
                DB::commit();
                return ResponseTrait::AllResponse('success', Response::HTTP_OK, 'Business Location Deleted Successfully', route('business_locations.index'));
            }
            throw new \Exception('Invalid Business Location Information',Response::HTTP_NOT_FOUND);
        }catch(\Exception $ex){
            DB::rollBack();
            return ResponseTrait::AllResponse('error', Response::HTTP_BAD_REQUEST, $ex->getMessage());
        }
    }
}
