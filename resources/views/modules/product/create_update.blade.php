@extends('layouts.app')

@section('pageTitle', !empty($product)? 'Update product':'Add new product')

@section('pageCss')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/pickers/pickadate/pickadate.css')}}">

    <style>
        .custom-file-label::after {
            color: #ffffff;
            background-color: #7b4bda;
        }
    </style>
@endsection

@section('pageContent')
    <div class="content-wrapper">
        <div class="content-header row">
            <?php
            $breadcrumbs = [
                'Product List' => route('products.index'),
                'Product Create' => !empty($product)? 'Update product':'Add new product'
            ];

            ?>
            @include('layouts.includes.breadcrumb', $breadcrumbs)
        </div>
        <div class="content-body">
            @if(!empty($product))
                <form class="form GlobalFormValidation" method="post" action="{{ route('products.update', $product->product_id) }}" >
                @method('PUT')
            @else
                <form class="form GlobalFormValidation" method="post" action="{{ route('products.store') }}">
            @endif
            @csrf
                <section class="users-edit">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>Product Name <b class="font-weight-bold text-warning">*</b></label>
                                                <input type="text" class="form-control"
                                                       name="product_name"
                                                       value="{{ !empty($product)? $product->product_name: '' }}"
                                                       placeholder="Product Name"
                                                       data-fv-notempty='true'
                                                       data-fv-blank='true'
                                                       data-rule-required='true'
                                                       data-fv-notempty-message='Product Name Is Required'
                                                       required
                                                >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>Product SKU <b class="font-weight-bold text-warning">*</b></label>
                                                <input type="text" class="form-control"
                                                       name="product_sku"
                                                       value="{{ !empty($product)? $product->product_sku: '' }}"
                                                       placeholder="Product SKU"
                                                       data-fv-notempty='true'
                                                       data-fv-blank='true'
                                                       data-rule-required='true'
                                                       data-fv-notempty-message='Product SKU Is Required'
                                                       required
                                                >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>Barcode <b class="font-weight-bold text-warning">*</b></label>
                                                <input type="text" class="form-control"
                                                       name="barcode"
                                                       value="{{ !empty($product)? $product->barcode: '' }}"
                                                       placeholder="Barcode"
                                                       data-fv-notempty='true'
                                                       data-fv-blank='true'
                                                       data-rule-required='true'
                                                       data-fv-notempty-message='Barcode Is Required'
                                                       required
                                                >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>Unites <b class="font-weight-bold text-warning">*</b></label>
                                                <select class="select2 form-control" name="unit_id"
                                                        data-fv-notempty='true'
                                                        data-fv-blank='true'
                                                        data-rule-required='true'
                                                        data-fv-notempty-message='Unit Is Required'
                                                        required
                                                >
                                                    <option value=" ">Select a Unit</option>
                                                    @if(!empty($unites) && count($unites) > 0)
                                                        @foreach($unites as $unit)
                                                            <option value="{{ $unit->unit_id }}" {{ !empty($product) && $product->unit_id==$unit->unit_id? 'selected': '' }}>{{ $unit->unit_name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>Category <b class="font-weight-bold text-warning">*</b></label>
                                                <select class="select2 form-control" name="category_id"
                                                        data-fv-notempty='true'
                                                        data-fv-blank='true'
                                                        data-rule-required='true'
                                                        data-fv-notempty-message='Category Is Required'
                                                        required
                                                >
                                                    <option value=" ">Select a Category</option>
                                                    @if(!empty($categories) && count($categories) > 0)
                                                        @foreach($categories as $category)
                                                            <option value="{{ $category->category_id }}"
                                                                {{ !empty($product) && $product->category_id==$category->category_id? 'selected': '' }}>{{ $category->category_name }}</option>
                                                            @foreach ($category->children as $child)
                                                                <option value="{{ $child->category_id }}"
                                                                    {{ !empty($product) && $product->category_id==$child->category_id? 'selected': '' }}
                                                                >-{{ $child->category_name }}</option>
                                                            @endforeach
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>Brand <b class="font-weight-bold text-warning">*</b></label>
                                                <select class="select2 form-control" name="brand_id"
                                                        data-fv-notempty='true'
                                                        data-fv-blank='true'
                                                        data-rule-required='true'
                                                        data-fv-notempty-message='Brand Is Required'
                                                        required
                                                >
                                                    <option value=" ">Select a Brand</option>
                                                    @if(!empty($brands) && count($brands) > 0)
                                                        @foreach($brands as $brandId=> $brandname)
                                                            <option value="{{ $brandId }}" {{ !empty($product) && $product->brand_id==$brandId? 'selected': '' }}>{{ $brandname }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="">
                                    <div class="row">
                                        <div class="col-md-8 col-lg-8 col-sm-12">
                                            <div class="form-group">
                                                <div class="controls">
                                                    <label>Short Description<b class="font-weight-bold text-warning">*</b></label>
                                                    <textarea name="short_description" rows="8"
                                                        class="form-control"
                                                        placeholder="Short Description"
                                                        data-fv-notempty='true'
                                                        data-fv-blank='true'
                                                        data-rule-required='true'
                                                        data-fv-notempty-message='Short Description Is Required'
                                                        required
                                                        >{{ !empty($product)? $product->short_description: '' }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-lg-4 col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-12 col-lg-12">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <label>Alert Qty <b class="font-weight-bold text-warning">*</b></label>
                                                            <input type="number" class="form-control"
                                                                   name="alert_qty"
                                                                   value="{{ !empty($product)? $product->alert_qty: '' }}"
                                                                   placeholder="Alert Qty"
                                                                   data-fv-notempty='true'
                                                                   data-fv-blank='true'
                                                                   data-rule-required='true'
                                                                   data-fv-notempty-message='Alert Qty Is Required'
                                                                   required
                                                            >
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-12 col-lg-12">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <label for="attachment">Product Image  @if(!empty($product) && !empty($product->attachment)) @else <b class="font-weight-bold text-warning">*</b>@endif</label>
                                                            <div class="flex">
                                                                <div class="input-group">
                                                                    <div style="width: 100%;">
                                                                        <div class="custom-file">
                                                                            <input type="file" name="image_path" class="custom-file-input file-input"
                                                                                   id="attachment" accept="application/pdf,text/csv,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,image/jpeg,image/jpg,image/png"
                                                                                   @if(empty($product) || empty($product->attachment))
                                                                                   data-fv-notempty='true'
                                                                                   data-fv-blank='true'
                                                                                   data-rule-required='true'
                                                                                   data-fv-notempty-message='Product Image Is Required'
                                                                                   required
                                                                                   @endif
                                                                            >
                                                                            <label class="custom-file-label" for="attachment" aria-describedby="inputGroupFile02">Choose file</label>
                                                                        </div>
                                                                    </div>
                                                                    <p class="text-help text-sm mr-1 mb-0">Max File Size: 1MB</p>
                                                                    <p class="text-help text-sm mb-0">Allowed File: .pdf, .csv, .doc, .docx, .jpeg, .jpg, .png</p>
                                                                </div>
                                                                <div class="file-preview box sm">
                                                                    @if(!empty($product) && !empty($product->attachment))
                                                                    <div class="d-flex justify-content-between align-items-center ml-1 file-preview-item"
                                                                         title="{{ $product->attachment->file_original_name }}">
                                                                        <div class="align-items-center align-self-stretch d-flex justify-content-center thumb">
                                                                            <img src="{{ $product->attachment->image_path }}" class="img-fit">
                                                                        </div>
                                                                        <div class="col body">
                                                                            <h6 class="d-flex">
                                                                                <span class="text-truncate title">{{ $product->attachment->file_original_name }}</span>
                                                                                <span class="ext">{{ $product->attachment->extension }}</span>
                                                                            </h6>
                                                                            <p>{{ $product->attachment->file_size }} KB</p>
                                                                        </div>
                                                                    </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>Taxes <b class="font-weight-bold text-warning">*</b></label>
                                                <select class="select2 form-control" id="tax_id" name="tax_id"
                                                        data-fv-notempty='true'
                                                        data-fv-blank='true'
                                                        data-rule-required='true'
                                                        data-fv-notempty-message='Tax Id Is Required'
                                                        required
                                                >
                                                    <option value="">Select a Taxes</option>
                                                    <option value="20">vat @20%</option>
                                                    <option value="10">vat @10%</option>
                                                    <option value="5">vat @5%</option>
                                                    {{-- @if(!empty($taxes) && count($taxes) > 0)
                                                        @foreach($taxes as $tax)
                                                            <option value="{{ $tax->tax_id }}" {{ !empty($product) && $product->tax_id==$tax->tax_id ? 'selected': '' }}>{{ $unit->unit_name }}</option>
                                                        @endforeach
                                                    @endif --}}
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4" >
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>Product Type <b class="font-weight-bold text-warning">*</b></label>
                                                <select class="select2 form-control" id="product_type" name="product_type"
                                                        placeholder="Product Type"
                                                        data-fv-notempty='true'
                                                        data-fv-blank='true'
                                                        data-rule-required='true'
                                                        data-fv-notempty-message='Product Type Is Required'
                                                        required
                                                >
                                                    <option value=" ">Select a Product Type</option>
                                                    @if(!empty($types) && count($types) > 0)
                                                        @foreach($types as $id => $name)
                                                            <option value="{{ $id }}" {{ !empty($product)&& $product->product_type == $id? 'selected': '' }}>{{ $name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12" id="comboBlock" style="display: {{ !empty($product)&& $product->product_type == \App\Models\Product::TYPES['Combo']? 'block': 'none' }};">
                                        <div class="form-group">
                                            <div class="row justify-content-center">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <button class="btn btn-primary" type="button"><i class="la la-search"></i></button>
                                                            </div>
                                                            <select class="form-control BCS-product-data-ajax BCS-product-sell" id="select2-ajax"></select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                <tr>
                                                    <th scope="col">Product Name</th>
                                                    <th scope="col">Quantity</th>
                                                    <th scope="col">Purchase Price (Excluding Tax)</th>
                                                    <th scope="col">Total Amount (Exc. Tax)</th>
                                                    <th scope="col">X</th>
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody id="product_show">
                                                </tbody>
                                            </table>
                                            <div class="float-right">
                                                <p>
                                                    <span> Net Total Amount: 0.00 </span>
                                                </p>
                                            </div>
                                        </div>

                                        <div class="row my-5">
                                            <div class="col-sm-12 col-md-6 col-lg-6">

                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                                        <label for="">x Margin(%):</label>
                                                        <input type="number" step="0.01" class="form-control" name="" value="25.00" id="">
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                                        <label for="">Default Selling Price:</label>
                                                        <input type="number" step="0.01" class="form-control" name="" value="0.00" id="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-3">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>Default Purchase Price <b class="font-weight-bold text-warning">*</b></label>
                                                <input type="number" class="form-control"
                                                       name="product_dpp"
                                                       id="dpp"
                                                       value="{{ !empty($product)? $product->product_dpp: '' }}"
                                                       placeholder="Default Purchase Price"
                                                       data-fv-notempty='true'
                                                       data-fv-blank='true'
                                                       data-rule-required='true'
                                                       data-fv-notempty-message='Product Dpp Is Required'
                                                       step="0.01"
                                                       required
                                                >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3">
                                        <div class="form-group">
                                            <div class="controls dppt">
                                                <label>Default Purchase Price Inc Tax <b class="font-weight-bold text-warning">*</b></label>
                                                <input type="number" class="form-control"
                                                       id="dpp_inc_tax"
                                                       name="product_dpp_inc_tax"
                                                       value="{{ !empty($product)? $product->product_dpp_inc_tax: '' }}"
                                                       placeholder="Default Purchase Price Inc Tax"
                                                       data-fv-notempty='true'
                                                       data-fv-blank='true'
                                                       data-rule-required='true'
                                                       data-fv-notempty-message='Product Dpp Inc Tax Is Required'
                                                       step="0.01"
                                                       required
                                                >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>Profit Percent <b class="font-weight-bold text-warning">*</b></label>
                                                <input type="text" class="form-control"
                                                       id="profit_parcent"
                                                       name="profit_percent"
                                                       value="{{ !empty($product)? $product->profit_percent: '' }}"
                                                       placeholder="Profit Percent"
                                                       data-fv-notempty='true'
                                                       data-fv-blank='true'
                                                       data-rule-required='true'
                                                       value="25"
                                                       data-fv-notempty-message='Profit Percent Is Required'
                                                       required
                                                >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>Default Selling Price <b class="font-weight-bold text-warning">*</b></label>
                                                <input type="number" class="form-control"
                                                    name="product_dsp"
                                                    id="selling_price"
                                                    value="{{ !empty($product)? $product->product_dsp: '' }}"
                                                    placeholder="Default Selling Price"
                                                    data-fv-notempty='true'
                                                    data-fv-blank='true'
                                                    data-rule-required='true'
                                                    data-fv-notempty-message='Product Dsp Is Required'
                                                    step="0.01"
                                                    required
                                                >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                                <div class="controls">
                                                    <label>Similar Products </label>
                                                    <select class="select2 form-control" multiple name="similar_products[]">
                                                        <option value=" ">Choose Similar Products</option>
                                                        @if(!empty($existProducts) && count($existProducts) > 0)
                                                            @foreach($existProducts as $id => $name)
                                                                <option value="{{ $id }}" {{ (!empty($product) && in_array($id, $product->similar_products()->pluck('sim_prod_id')->toArray())) ? 'selected': '' }}>{{ $name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        @include('layouts.includes.alert_messages')
                                    </div>
                                    <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1">
                                        <button type="reset" class="btn btn-light mr-0 mr-sm-1">Reset</button>
                                        <button type="submit" class="btn btn-primary glow mb-1 mb-sm-0">Add Product</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </form>
        </div>
    </div>
@endsection

@section('pageJs')
    <script>
        var tax =''
        $(document).ready(function () {
            $('#product_type').on('change', function (e) {
                $('#comboBlock').hide();
                if(e.target.value == {{ \App\Models\Product::TYPES['Combo'] }}){
                    $('#comboBlock').show();
                }
            });

            $('#tax_id').on('change',function(e){
                var tax = e.target.value
                $('#dpp').on('input', function(e){
                    var dpp = e.target.value;
                    var dppt = parseInt(tax) / parseInt(dpp) * 100 ;
                    $('#dpp_inc_tax').val(dppt)

                    $('#profit_parcent').on('input',function(e){
                        var profit_parcent = e.target.value
                        var sell = parseInt(profit_parcent) / parseInt(tax) * 100 ;
                        $('#selling_price').val(sell)
                    })
                })
            })//end dpp and dpp_inc_tax
        });

        $('.BCS-product-data-ajax').on('select2:select', function (e) {
            var data = e.params.data;
            console.log(data)
                $('#product_show').append(' <tr> <td>'+ data.product_name +'</td>    <td><input type="number" value="1"></td>   <td> '+data.product_dpp+' </td> <td> '+ data.product_dpp*1 +' </td> <td> <a class="btn btn-sm btn-danger" href="">X</a> </td>  </tr>')
                    $(this).val(null).trigger('change');
        });


    </script>

@endsection
{{-- /*
* Author: Arup Kumer Bose
* Email: arupkumerbose@gmail.com
* Company Name: Brainchild Software <brainchildsoft@gmail.com>
*/ --}}
