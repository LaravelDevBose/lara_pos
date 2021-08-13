<?php

namespace App\Http\Controllers;

use App\Models\ExpanseHead;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ExpanseHeadController extends Controller
{
    public function index(Request $request)
    {
        $expanse_heads = ExpanseHead::query()->notDelete()->latest()->paginate(20);
        return view('modules.expanse_head.index',compact('expanse_heads'));
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
            'head_title' => ['required','string', 'unique:expanse_heads,head_title'],
        ],[
            'head_title.required'=> 'Head title is required',
            'head_title.string'=> 'Head title Must be string',
            'head_title.unique'=> 'This Head title is already added',
        ]);
        if ($validator->passes()) {
            try {
                DB::beginTransaction();
                $expanse_head = ExpanseHead::create([
                    'head_title' => $request->head_title,
                    'head_note' => !empty($request->head_note)? $request->head_note : null,
                    'status' => !empty($request->get('status')) ? $request->status : config('constant.inactive')
                ]);
                if (!empty($expanse_head)) {
                    DB::commit();
                    return ResponseTrait::AllResponse('success', Response::HTTP_OK, 'Expanse Head Created Successfully', route('expanse_heads.index'));
                }
                throw new \Exception('Invalid Expanse Head  Information');
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
        $expanse_head = ExpanseHead::findOrFail($id);
        $expanse_heads = ExpanseHead::query()->notDelete()->latest()->paginate(20);
        return view('modules.expanse_head.index', compact('expanse_head', 'expanse_heads'));
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
            'head_title' => ['required', 'string', Rule::unique('expanse_heads', 'head_title')->ignore($id,'head_id')],
        ],[
            'head_title.required'=> 'Expanse Head Title is Required',
            'head_title.string'=> 'Expanse Head Title Must be String',
            'head_title.unique'=> 'Expanse Head is Already Added',
        ]);
        if ($validator->passes()) {
            try {
                DB::beginTransaction();
                $expanse_head = ExpanseHead::find($id);
                if (empty($expanse_head)) {
                    throw new \Exception('Invalid Expanse Head Information');
                }
                $expanse_headU = $expanse_head->update([
                    'head_title' => $request->head_title,
                    'head_note' => !empty($request->head_note)? $request->head_note : null,
                    'status' => !empty($request->get('status')) ? $request->status : config('constant.inactive')
                ]);

                if (!empty($expanse_headU)) {
                    DB::commit();
                    return ResponseTrait::AllResponse('success', Response::HTTP_OK, 'Expanse Head Updated Successfully', route('expanse_heads.index'));
                }
                throw new \Exception('Invalid Expanse Head Information');
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
            $expanse_head = ExpanseHead::find($id);
            if (empty($expanse_head)){
                throw new \Exception('Invalid Expanse Head Information',Response::HTTP_NOT_FOUND);
            }
            if(ExpanseHead::find($id)->delete()){
                DB::commit();
                return ResponseTrait::AllResponse('success', Response::HTTP_OK, 'Expanse Head Deleted Successfully', route('expanse_heads.index'));
            }
            throw new \Exception('Invalid ExpanseHead Information',Response::HTTP_NOT_FOUND);
        }catch(\Exception $ex){
            DB::rollBack();
            return ResponseTrait::AllResponse('error', Response::HTTP_BAD_REQUEST, $ex->getMessage());
        }
    }
}
