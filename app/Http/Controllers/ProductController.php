<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{
    public function index(){
        return view('modules.product.index');
    }

    public function datatable(Request $request)
    {
        $dataTable = Product::query()->notDelete()
            ->with('category', 'brand')->latest();

        return DataTables::of($dataTable)
            ->editColumn('category_id', function ($data){
                return $data->category->category_name;
            })
            ->editColumn('brand_id', function ($data){
                return $data->brand->brand_name;
            })
            ->editColumn('product_type', function ($data){
                $types = array_flip(Product::TYPES);
                return $types[$data->product_type];
            })
            ->addColumn('image', function ($data){
                return '<img src="'.$data->attachment->image_path.'" style="width:40px; height:40px;">';
            })
            ->addColumn('action',function($data){
                $actionButton = '<span class="dropdown">
                                    <a id="btnSearchDrop2" href="#" title="Action" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="dropdown-toggle dropdown-menu-right btn btn-info btn-sm"><i class="la la-cogs"></i></a>
                                    <span aria-labelledby="btnSearchDrop2" class="dropdown-menu mt-1 dropdown-menu-right">';
                $actionButton .= '<a  href="' . route('products.edit', $data->product_id) . '"  title="Edit" class="dropdown-item"><i class="far fa-edit"></i> Edit </a>';
                $actionButton .= '</span></span>';
                return $actionButton;
            })->rawColumns(['action', 'image'])->make(true);

    }

    public function create(Request $request){
        $categories = Category::onlyParents()->isActive()->latest()
        ->with(['children' => function($query){
            return $query->isActive();
        }])->get();

        $brands = Brand::isActive()->latest()->pluck('brand_name', 'brand_id');
        $types = array_flip(Product::TYPES);
        $existProducts = Product::isActive()->latest()->pluck('product_reference', 'product_id');
        return view('modules.product.create_update', compact('categories', 'brands', 'types', 'existProducts'));
    }

    public function store(Request $request)
    {

        $rules = [
            'category_id' => ['required'],
            'brand_id' => ['required'],
            'barcode' => ['required', 'string'],
            'product_reference' => ['required', 'string'],
            'short_description' => ['required', 'string'],
            'profit_margin' => ['nullable', 'numeric'],
            'product_tva' => ['required', 'numeric'],
            'min_stock' => ['required', 'numeric'],
            'max_stock' => ['required', 'numeric'],
            'product_type' => ['required'],
            'image_path' => ['required', 'image', 'mimes:jpeg,jpg,png','max:500'],
            'similar_products' => ['nullable', 'array'],
        ];
        $messages = [
            'category_id.required'=> 'Category is Required',
            'brand_id.required'=> 'Brand is Required',
            'barcode.required'=> 'Barcode is Required',
            'barcode.string'=> 'Barcode name Must be String',
            'product_reference.required'=> 'Product Reference is Required',
            'product_reference.string'=> 'Product Reference Must be String',
            'short_description.required'=> 'Short Description is Required',
            'short_description.string'=> 'Short Description Must be String',
            'profit_margin.numeric'=> 'Profit Margin must be Numeric',
            'product_tva.required'=> 'TVA is Required',
            'product_tva.numeric'=> 'TVA must be Numeric',
            'min_stock.required'=> 'Min Stock is Required',
            'min_stock.numeric'=> 'Min Stock be Numeric',
            'max_stock.required'=> 'Max Stock is Required',
            'max_stock.numeric'=> 'Max Stock must be Numeric',
            'product_type.required'=> 'Product Type is Required',
            'image_path.required'=> 'Product Image is Required',
            'image_path.image'=> 'Product Image must be an valid image',
            'image_path.mimes'=> 'Product Image support only jpeg,jpg,png format',
            'image_path.max'=> 'Product Image max:500kb size',
            'similar_products.array'=> 'Please Select Valid Similar Products',
        ];


        if($request->product_type == Product::TYPES['Combo']){
            $rules = array_merge($rules, [
                'combo_products'=>['required', 'array', 'min:2']
            ]);
            $messages = array_merge($messages, [
                'combo_products.required'=> 'Please Select Combo Products',
                'combo_products.array'=> 'Please Select Valid Combo Products',
                'combo_products.min'=> 'Select min:2 Products for Combo Product',
            ]);
        }
        $validator = Validator::make($request->all(),$rules,$messages);
        if ($validator->passes()) {
            try {
                DB::beginTransaction();
                $product = Product::create([
                    'category_id' => $request->category_id,
                    'brand_id' => $request->brand_id,
                    'barcode' => $request->barcode,
                    'product_reference' => $request->product_reference,
                    'short_description' => $request->short_description,
                    'long_description' => $request->long_description,
                    'profit_margin' => !empty($request->profit_margin)? $request->profit_margin: 0,
                    'product_tva' => !empty($request->product_tva)? $request->product_tva: 0,
                    'min_stock' => !empty($request->min_stock)? $request->min_stock: 0,
                    'max_stock' => !empty($request->max_stock)? $request->max_stock: 0,
                    'product_type'=> !empty($request->product_type)? $request->product_type: Product::TYPES['Single'],
                    'status' => !empty($request->get('status')) ? $request->status : config('constant.inactive')
                ]);
                if (!empty($product)) {

                    if(!empty($request->image_path)){
                       $product->singleUploadImage($request->file('image_path'));
                    }

                    if ($request->product_type == Product::TYPES['Combo']){
                        if (empty($request->combo_products) || count($request->combo_products) <= 0){
                            throw new \Exception('Invalid Combo products information');
                        }
                        $combo = $product->combos()->attach($request->combo_products);

                        if (empty($combo)){
                            throw new \Exception('Invalid Combo Products information');
                        }
                    }
                    if (!empty($request->similar_products) && count($request->similar_products) > 0){
                        $similar = $product->similars()->attach($request->similar_products);
                        if (empty($similar)){
                            throw new \Exception('Invalid Combo Products information');
                        }
                    }

                    DB::commit();
                    return ResponseTrait::AllResponse('success', Response::HTTP_OK, 'Product Created Successfully', route('products.index'));
                }
                throw new \Exception('Invalid Product Information');
            } catch (\Exception $ex) {
                DB::rollBack();
                return ResponseTrait::AllResponse('error', Response::HTTP_BAD_REQUEST, $ex->getMessage());
            }
        }else{
            return ResponseTrait::ValidationResponse(array_values($validator->errors()->getMessages()), 'validation');
        }
    }

    public function edit($id)
    {
        $product = Product::with('attachment', 'combo_products', 'similar_products')->where('product_id', $id)->firstOrFail();
        $categories = Category::onlyParents()->isActive()->latest()
            ->with(['children' => function($query){
                return $query->isActive();
            }])->get();

        $brands = Brand::isActive()->latest()->pluck('brand_name', 'brand_id');
        $types = array_flip(Product::TYPES);
        $existProducts = Product::isActive()->where('product_id', '!=', $id)->latest()->pluck('product_reference', 'product_id');
        return view('modules.product.create_update', compact('categories', 'brands', 'types', 'product', 'existProducts'));
    }

    public function update(Request $request, $id)
    {

        $rules = [
            'category_id' => ['required'],
            'brand_id' => ['required'],
            'barcode' => ['required', 'string'],
            'product_reference' => ['required', 'string'],
            'short_description' => ['required', 'string'],
            'profit_margin' => ['nullable', 'numeric'],
            'product_tva' => ['required', 'numeric'],
            'min_stock' => ['required', 'numeric'],
            'max_stock' => ['required', 'numeric'],
            'product_type' => ['required'],
            'image_path' => ['nullable', 'image', 'mimes:jpeg,jpg,png','max:500'],
            'similar_products' => ['nullable', 'array'],
        ];
        $messages = [
            'category_id.required'=> 'Category is Required',
            'brand_id.required'=> 'Brand is Required',
            'barcode.required'=> 'Barcode is Required',
            'barcode.string'=> 'Barcode name Must be String',
            'product_reference.required'=> 'Product Reference is Required',
            'product_reference.string'=> 'Product Reference Must be String',
            'short_description.required'=> 'Short Description is Required',
            'short_description.string'=> 'Short Description Must be String',
            'profit_margin.numeric'=> 'Profit Margin must be Numeric',
            'product_tva.required'=> 'TVA is Required',
            'product_tva.numeric'=> 'TVA must be Numeric',
            'min_stock.required'=> 'Min Stock is Required',
            'min_stock.numeric'=> 'Min Stock be Numeric',
            'max_stock.required'=> 'Max Stock is Required',
            'max_stock.numeric'=> 'Max Stock must be Numeric',
            'product_type.required'=> 'Product Type is Required',
            'image_path.image'=> 'Product Image must be an valid image',
            'image_path.mimes'=> 'Product Image support only jpeg,jpg,png format',
            'image_path.max'=> 'Product Image max:500kb size',
            'similar_products.array'=> 'Please Select Valid Similar Products',
        ];


        if($request->product_type == Product::TYPES['Combo']){
            $rules = array_merge($rules, [
                'combo_products'=>['required', 'array', 'min:2']
            ]);
            $messages = array_merge($messages, [
                'combo_products.required'=> 'Please Select Combo Products',
                'combo_products.array'=> 'Please Select Valid Combo Products',
                'combo_products.min'=> 'Select min:2 Products for Combo Product',
            ]);
        }
        $validator = Validator::make($request->all(),$rules,$messages);
        if ($validator->passes()) {
            try {
                DB::beginTransaction();

                $product = Product::find($id);

                if (empty($product)){
                    throw new \Exception('Invalid Product Information');
                }

                $productU =$product->update([
                    'category_id' => $request->category_id,
                    'brand_id' => $request->brand_id,
                    'barcode' => $request->barcode,
                    'product_reference' => $request->product_reference,
                    'short_description' => $request->short_description,
                    'long_description' => $request->long_description,
                    'profit_margin' => !empty($request->profit_margin)? $request->profit_margin: 0,
                    'product_tva' => !empty($request->product_tva)? $request->product_tva: 0,
                    'min_stock' => !empty($request->min_stock)? $request->min_stock: 0,
                    'max_stock' => !empty($request->max_stock)? $request->max_stock: 0,
                    'product_type'=> !empty($request->product_type)? $request->product_type: Product::TYPES['Single'],
                ]);
                if (!empty($product)) {

                    if(!empty($request->image_path)){
                        $product->singleUploadImage($request->file('image_path'));
                    }

                    if ($product->product_type == Product::TYPES['Combo'] && $request->product_type == Product::TYPES['Single']){
                        $product->combos()->delete();
                    }

                    if ($request->product_type == Product::TYPES['Combo']){
                        if (empty($request->combo_products) || count($request->combo_products) <= 0){
                            throw new \Exception('Invalid Combo products information');
                        }
                        $combo = $product->combos()->attach($request->combo_products);

                        if (empty($combo)){
                            throw new \Exception('Invalid Combo Products information');
                        }
                    }
                    if (!empty($request->similar_products) && count($request->similar_products) > 0){
                        $similar = $product->similars()->sync($request->similar_products);
                        if (empty($similar)){
                            throw new \Exception('Invalid Similar Products information');
                        }
                    }

                    DB::commit();
                    return ResponseTrait::AllResponse('success', Response::HTTP_OK, 'Product Updated Successfully', route('products.index'));
                }
                throw new \Exception('Invalid Product Information');
            } catch (\Exception $ex) {
                DB::rollBack();
                return ResponseTrait::AllResponse('error', Response::HTTP_BAD_REQUEST, $ex->getMessage());
            }
        }else{
            return ResponseTrait::ValidationResponse(array_values($validator->errors()->getMessages()), 'validation');
        }
    }

    public function ajax_get_products(Request $request)
    {
        $products = Product::query()->isActive()->searchBy($request)->get();
        return ResponseTrait::SingleResponse($products, 'success', Response::HTTP_OK);
    }
}
 