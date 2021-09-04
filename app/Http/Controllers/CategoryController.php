<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Exception;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::query()->notDelete()->with(['parent'])->latest()->paginate(20);
        $parents = Category::isActive()->onlyParents()->orderBy('category_name', 'asc')->pluck('category_name', 'category_id');
        return view('admin.category.index',compact('categories', 'parents'));
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
            'category_name' => ['required','string', 'unique:categories,category_name'],
        ],[
            'name.required'=> 'Category name is Required',
            'name.string'=> 'Category name Must be String',
            'name.unique'=> 'Category is Already Added',
        ]);
        if ($validator->passes()) {
            try {
                DB::beginTransaction();
                $category = Category::create([
                    'category_name' => $request->category_name,
                    'parent_id'=> !empty($request->parent_id)? $request->parent_id: null,
                    'status' => !empty($request->get('status')) ? $request->status : config('constant.inactive')
                ]);
                if (!empty($category)) {
                    DB::commit();
                    return ResponseTrait::AllResponse('success', Response::HTTP_OK, 'Category Created Successfully', route('category.index'));
                }
                throw new \Exception('Invalid Category Information');
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
        $category = Category::findOrFail($id);
        $categories = Category::notDelete()->with('parent')->latest()->paginate(20);
        $parents = Category::onlyParents()->orderBy('category_name', 'asc')->pluck('category_name', 'category_id');
        return view('admin.category.index', compact('category', 'categories', 'parents'));
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
            'category_name' => ['required', 'string',Rule::unique('categories', 'category_name')->ignore($id,'category_id')],
        ],[
            'category_name.required'=> 'Category name is Required',
            'category_name.string'=> 'Category name Must be String',
            'category_name.unique'=> 'Category is Already Added',
        ]);
        if ($validator->passes()) {
            try {
                DB::beginTransaction();
                $category = Category::find($id);
                if (empty($category)) {
                    throw new \Exception('Invalid Category Information');
                }
                $category = $category->update([
                    'category_name' => $request->category_name,
                    'parent_id'=> !empty($request->parent_id)? $request->parent_id: null,
                    'status' => !empty($request->get('status')) ? $request->status : config('constant.inactive')
                ]);

                if (!empty($categoryU)) {
                    DB::commit();
                    return ResponseTrait::AllResponse('success', Response::HTTP_OK, 'Category Updated Successfully', route('category.index'));
                }
                throw new \Exception('Invalid Category Information');
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
            $category = Category::find($id);
            if (empty($category)){
                throw new \Exception('Invalid Category Information',Response::HTTP_NOT_FOUND);
            }
            if(Category::find($id)->delete()){
                DB::commit();
                return ResponseTrait::AllResponse('success', Response::HTTP_OK, 'Category Deleted Successfully', route('category.index'));
            }
            throw new \Exception('Invalid Category Information',Response::HTTP_NOT_FOUND);
        }catch(Exception $ex){
            DB::rollBack();
            return ResponseTrait::AllResponse('error', Response::HTTP_BAD_REQUEST, $ex->getMessage());
        }
    }
}
