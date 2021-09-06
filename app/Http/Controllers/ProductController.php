<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tax;
use App\Models\Unit;
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
            ->with('category', 'brand', 'tax', 'unit', 'attachment')->latest();

        return DataTables::of($dataTable)
            ->editColumn('product_name', function ($data){
                return $data->product_name.' <small> ('.$data->product_code.') </small>';
            })
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
            ->editColumn('tax_id', function ($data){
                return $data->tax->tax_info;
            })
            ->editColumn('status', function ($data){
                return ($data->status == config('constant.active'))? '<span class="badge badge-success badge-md">Active</span>': '<span class="badge badge-warning badge-md">Inactive</span>';
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
            })->rawColumns(['action', 'image', 'status', 'product_name'])->make(true);

    }

    public function create(Request $request){
        $categories = Category::onlyParents()->isActive()->latest()
        ->with(['children' => function($query){
            return $query->isActive();
        }])->get();

        $brands = Brand::isActive()->latest()->pluck('brand_name', 'brand_id');
        $unites = Unit::isActive()->latest()->get()->pluck('unit_info', 'unit_id');
        $taxes = Tax::isActive()->latest()->get();
        $types = array_flip(Product::TYPES);
        $existProducts = Product::isActive()->latest()->pluck('product_id');
        return view('modules.product.create_update', compact('categories', 'brands', 'types', 'existProducts','unites','taxes'));
    }

    public function store(Request $request)
    {


        $rules = [
            'product_name' => ['required', 'string'],
            'product_sku' => ['required', 'string'],
            'barcode' => ['required', 'string'],
            'unit_id' => ['required'],
            'category_id' => ['required'],
            'brand_id' => ['required'],
            'short_description' => ['nullable', 'string'],
            'alert_qty' => ['required'],
            'image_path' => ['required', 'image', 'mimes:jpeg,jpg,png','max:500'],
//            'tax_id' => ['required'],
            'product_type' => ['nullable'],
            'product_dpp'=> ['required'],
            'product_dpp_inc_tax'=> ['required'],
            'profit_percent'=> ['required'],
            'product_dsp'=> ['required'],
            'similar_products' => ['nullable', 'array'],
        ];

        $messages = [
            'product_name' => ['Product Name is Required'],
            'product_sku' => ['Product Sku is Required'],
            'barcode.required'=> 'Barcode is Required',
            'barcode.string'=> 'Barcode name Must be String',
            'unit_id' => ['Unit is Required'],
            'category_id.required'=> 'Category is Required',
            'brand_id.required'=> 'Brand is Required',
            'alert_qty' => ['Alert Quantity is Required'],
            'short_description.required'=> 'Short Description is Required',
            'short_description.string'=> 'Short Description Must be String',
            'tax_id' => ['Tax is Required'],
            'product_dpp'=> 'Default Purchase Price is Required',
            'product_dpp_inc_tax'=> 'Default Purchase Price Inc Tax is Required',
            'profit_percent'=> 'Profit Percent is Required',
            'product_dsp'=> 'Default Selling Price is Required',
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
                    'product_name' => $request->product_name,
                    'product_sku' => $request->product_sku,
                    'product_code' => Product::getCode(),
                    'barcode' => $request->barcode,
                    'unit_id' => $request->unit_id,
                    'category_id' => $request->category_id,
                    'brand_id' => $request->brand_id,
                    'short_description' => $request->short_description,
                    'alert_qty' => $request->alert_qty,
                    'product_type'=> !empty($request->product_type)? $request->product_type: Product::TYPES['Single'],
                    'tax_id' => $request->tax_id,
                    'product_dpp' => !empty($request->product_dpp)? $request->product_dpp: 0,
                    'product_dpp_inc_tax' => !empty($request->product_dpp_inc_tax)? $request->product_dpp_inc_tax: 0,
                    'profit_percent' => !empty($request->profit_percent)? $request->profit_percent: 0,
                    'product_dsp' => !empty($request->product_dsp)? $request->product_dsp: 0,
                    'similar_products' => $request->similar_products,
                    'status' => !empty($request->get('status')) ? $request->status : config('constant.active')
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
                            throw new \Exception('Invalid Simillar Products information');
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
            'product_name' => ['required', 'string'],
            'product_sku' => ['required', 'string'],
            'barcode' => ['required', 'string'],
            'unit_id' => ['required'],
            'category_id' => ['required'],
            'brand_id' => ['required'],
            'short_description' => ['nullable', 'string'],
            'alert_qty' => ['required'],
            'image_path' => ['required', 'image', 'mimes:jpeg,jpg,png','max:500'],
            'tax_id' => ['required'],
            'product_type' => ['nullable'],
            'product_dpp'=> ['required'],
            'product_dpp_inc_tax'=> ['required'],
            'profit_percent'=> ['required'],
            'product_dsp'=> ['required'],
            'similar_products' => ['nullable', 'array'],
        ];
        $messages = [
            'product_name' => ['Product Name is Required'],
            'product_sku' => ['Product Sku is Required'],
            'barcode.required'=> 'Barcode is Required',
            'barcode.string'=> 'Barcode name Must be String',
            'unit_id' => ['Unit is Required'],
            'category_id.required'=> 'Category is Required',
            'brand_id.required'=> 'Brand is Required',
            'alert_qty' => ['Alert Quantity is Required'],
            'short_description.required'=> 'Short Description is Required',
            'short_description.string'=> 'Short Description Must be String',
            'tax_id' => ['Taxs is Required'],
            'product_dpp'=> 'Default Purchase Price is Required',
            'product_dpp_inc_tax'=> 'Default Purchase Price Inc Tax is Required',
            'profit_percent'=> 'Profit Percent is Required',
            'product_dsp'=> 'Default Selling Price is Required',
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
        // return response()->json($request->all());
        $products = Product::query()->isActive()->searchBy($request)
            ->with('attachment')->get();
        return ResponseTrait::SingleResponse($products, 'success', Response::HTTP_OK);
    }

    //product show on purchase page
    public function purchase_product($id)
    {

        $product = Product::query()->Purchase($id);
        return response()->json($product, 200);
    }
}
