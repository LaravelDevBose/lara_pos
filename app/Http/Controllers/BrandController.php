<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Validation\Rule;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $brands = Brand::query()->notDelete()->searchBy($request)->latest()->paginate(20);
        return view('admin.brand.index',compact('brands'));
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
            'brand_name' => ['required','string', 'unique:brands,brand_name'],
        ],[
            'brand_name.required'=> 'Brand name is Required',
            'brand_name.string'=> 'Brand name Must be String',
            'brand_name.unique'=> 'Brand is Already Added',
        ]);
        if ($validator->passes()) {
            try {
                DB::beginTransaction();
                $brand = Brand::create([
                    'brand_name' => $request->brand_name,
                    'status' => !empty($request->get('status')) ? $request->status : config('constant.inactive')
                ]);
                if (!empty($brand)) {
                    DB::commit();
                    return ResponseTrait::AllResponse('success', Response::HTTP_OK, 'Brand Created Successfully', route('brand.index'));
                }
                throw new \Exception('Invalid Brand Information');
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
        $brand = Brand::findOrFail($id);
        $brands = Brand::query()->notDelete()->latest()->paginate(20);
        return view('admin.brand.index', compact('brand', 'brands'));
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
            'brand_name' => ['required', 'string',Rule::unique('brands', 'brand_name')->ignore($id,'brand_id')],
        ],[
            'brand_name.required'=> 'Brand name is Required',
            'brand_name.string'=> 'Brand name Must be String',
            'brand_name.unique'=> 'Brand is Already Added',
        ]);
        if ($validator->passes()) {
            try {
                DB::beginTransaction();
                $brand = Brand::find($id);
                if (empty($brand)) {
                    throw new \Exception('Invalid Brand Information');
                }
                $brandU = $brand->update([
                    'brand_name' => $request->brand_name,
                    'status' => !empty($request->get('status')) ? $request->status : config('constant.inactive')
                ]);

                if (!empty($brandU)) {
                    DB::commit();
                    return ResponseTrait::AllResponse('success', Response::HTTP_OK, 'Brand Updated Successfully', route('brand.index'));
                }
                throw new \Exception('Invalid Brand Information');
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
            $brand = Brand::find($id);
            if (empty($brand)){
                throw new \Exception('Invalid Brand Information',Response::HTTP_NOT_FOUND);
            }
            if(Brand::find($id)->delete()){
                DB::commit();
                return ResponseTrait::AllResponse('success', Response::HTTP_OK, 'Brand Deleted Successfully', route('brand.index'));
            }
            throw new \Exception('Invalid Brand Information',Response::HTTP_NOT_FOUND);
        }catch(Exception $ex){
            DB::rollBack();
            return ResponseTrait::AllResponse('error', Response::HTTP_BAD_REQUEST, $ex->getMessage());
        }
    }
}
