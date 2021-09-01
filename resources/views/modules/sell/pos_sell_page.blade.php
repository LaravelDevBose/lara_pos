@extends('layouts.app')

@section('pageTitle', 'Add New Sell')

@section('pageCss')
<link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/pickers/pickadate/pickadate.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/plugins/animate/animate.css') }}">
<style>
    .select2.select2-container {
        width: 90% !important;
    }
</style>
@endsection

@section('pageContent')
<div class="content-wrapper">
    <div class="content-header row">
        <?php
        $breadcrumbs = [
            'Pos' => route('pos.index'),
            'Purchese Create' => 'pos'
        ];

        ?>
        @include('layouts.includes.breadcrumb', $breadcrumbs)

    </div>


    <!--pos design start here-->
    <section>
        <div class="row">
            <div class="col-sm-12 col-md-7 col-lg-7">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12- col-md-5 col-lg-5">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <select class="select2 form-control " name="customer_id" id="customer_id">
                                                <option value="">--Select Customer--</option>
                                                @foreach ($customers as $item)
                                                    <option value="{{ $item->contact_id }}"> {{ $item->first_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-7 col-lg-7">
                                    <fieldset>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <button class="btn btn-primary" type="button"><i
                                                        class="la la-search"></i></button>
                                            </div>
                                            <input type="text" class="form-control"
                                                placeholder="Enter product name/ SKU" aria-label="Amount">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="button">+</button>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="">
                                <table class="table table-bordered ">
                                    <thead>
                                        <tr>
                                            <th scope="col">Product</th>
                                            <th scope="col">Qty</th>
                                            <th scope="col">Price inc. tax </th>
                                            <th scope="col">Subtotal</th>
                                            <th scope="col">X</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">sandilina shop</th>
                                            <td>1</td>
                                            <td>100$</td>
                                            <td>100$</td>
                                            <td class="text-danger">X</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <hr>
                                <div style="margin-top: 200px">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-4 col-lg-4">
                                            <p><strong>Items</strong> 0</p>
                                            <p><strong>Discount<i class="text-info h4 ft-info"></i>(-):</strong> <i
                                                    class="h4 ft-edit"></i> 0.00</p>
                                        </div>
                                        <div class="col-md-8 col-lg-8 col-sm-12">
                                            <p><strong>Total:</strong> 0.00</p>
                                            <p>
                                                <span><strong>Order Tax(+):<i class="text-info h4 ft-info"></i>
                                                    </strong><i class="h4 ft-edit"></i>0.00</span> <span
                                                    class="float-right"><strong>Shipping(+):</strong><i
                                                        class="text-info h4 ft-info"></i><i class="h4 ft-edit"></i> 0.00
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end of left side -->
            <!--pos product show start here-->
            <div class="col-sm-12 col-md-5 col-lg-5">
                <!--category and brand start here -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="controls">
                                <select class="select2 form-control" name="category_id" id="category_id">
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
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="input-group">
                                <select class="select2 form-control " name="brand_id" id="brand_id">
                                    <option value="">--Select Brand--</option>
                                    @foreach ($brands as $item)
                                        <option value="{{ $item->brand_id }}"> {{ $item->brand_name}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div id="BCS_products_container">
                            <div id="BCS_loader">
                                <i class="la la-spinner spinner"></i>
                            </div>
                            <div id="BCS_message" style="display: none">
                                <div class="alert alert-light mb-2" role="alert">
                                    <strong>Message!</strong> <span id="msg"></span>
                                </div>
                            </div>
                            <div id="BCS_products" style="display: none">
                                <div class="row ex1">
                                    <div class="col-sm-12 col-md-3 col-lg-3 product-list">
                                        <div class="card">
                                            <div class="card-content">
                                                <img class="product-img"
                                                     src="https://picsum.photos/seed/picsum/200/300"
                                                     alt="Card image cap"
                                                >
                                                <div class="mt-1 text-center">
                                                    <h4 class="card-title">Card title</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3 col-lg-3 product-list">
                                        <div class="card">
                                            <div class="card-content">
                                                <img class="card-img-top img-fluid"
                                                     src="https://picsum.photos/seed/picsum/200/300"
                                                     alt="Card image cap"
                                                     style="height: 6rem;"
                                                >
                                                <div class="mt-1 text-center">
                                                    <h4 class="card-title">Card title</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3 col-lg-3 product-list">
                                        <div class="card">
                                            <div class="card-content">
                                                <img class="card-img-top img-fluid"
                                                     src="https://picsum.photos/seed/picsum/200/300"
                                                     alt="Card image cap"
                                                     style="height: 6rem;"
                                                >
                                                <div class="mt-1 text-center">
                                                    <h4 class="card-title">Card title</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3 col-lg-3 product-list">
                                        <div class="card">
                                            <div class="card-content">
                                                <img class="card-img-top img-fluid"
                                                     src="https://picsum.photos/seed/picsum/200/300"
                                                     alt="Card image cap"
                                                     style="height: 6rem;"
                                                >
                                                <div class="mt-1 text-center">
                                                    <h4 class="card-title">Card title</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3 col-lg-3 product-list">
                                        <div class="card">
                                            <div class="card-content">
                                                <img class="card-img-top img-fluid"
                                                     src="https://picsum.photos/seed/picsum/200/300"
                                                     alt="Card image cap"
                                                     style="height: 6rem;"
                                                >
                                                <div class="mt-1 text-center">
                                                    <h4 class="card-title">Card title</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3 col-lg-3 product-list">
                                        <div class="card">
                                            <div class="card-content">
                                                <img class="card-img-top img-fluid"
                                                     src="https://picsum.photos/seed/picsum/200/300"
                                                     alt="Card image cap"
                                                     style="height: 6rem;"
                                                >
                                                <div class="mt-1 text-center">
                                                    <h4 class="card-title">Card title</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3 col-lg-3 product-list">
                                        <div class="card">
                                            <div class="card-content">
                                                <img class="card-img-top img-fluid"
                                                     src="https://picsum.photos/seed/picsum/200/300"
                                                     alt="Card image cap"
                                                     style="height: 6rem;"
                                                >
                                                <div class="mt-1 text-center">
                                                    <h4 class="card-title">Card title</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3 col-lg-3 product-list">
                                        <div class="card">
                                            <div class="card-content">
                                                <img class="card-img-top img-fluid"
                                                     src="https://picsum.photos/seed/picsum/200/300"
                                                     alt="Card image cap"
                                                     style="height: 6rem;"
                                                >
                                                <div class="mt-1 text-center">
                                                    <h4 class="card-title">Card title</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3 col-lg-3 product-list">
                                        <div class="card">
                                            <div class="card-content">
                                                <img class="card-img-top img-fluid"
                                                     src="https://picsum.photos/seed/picsum/200/300"
                                                     alt="Card image cap"
                                                     style="height: 6rem;"
                                                >
                                                <div class="mt-1 text-center">
                                                    <h4 class="card-title">Card title</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3 col-lg-3 product-list">
                                        <div class="card">
                                            <div class="card-content">
                                                <img class="card-img-top img-fluid"
                                                     src="https://picsum.photos/seed/picsum/200/300"
                                                     alt="Card image cap"
                                                     style="height: 6rem;"
                                                >
                                                <div class="mt-1 text-center">
                                                    <h4 class="card-title">Card title</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3 col-lg-3 product-list">
                                        <div class="card">
                                            <div class="card-content">
                                                <img class="card-img-top img-fluid"
                                                     src="https://picsum.photos/seed/picsum/200/300"
                                                     alt="Card image cap"
                                                     style="height: 6rem;"
                                                >
                                                <div class="mt-1 text-center">
                                                    <h4 class="card-title">Card title</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3 col-lg-3 product-list">
                                        <div class="card">
                                            <div class="card-content">
                                                <img class="card-img-top img-fluid"
                                                     src="https://picsum.photos/seed/picsum/200/300"
                                                     alt="Card image cap"
                                                     style="height: 6rem;"
                                                >
                                                <div class="mt-1 text-center">
                                                    <h4 class="card-title">Card title</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3 col-lg-3 product-list">
                                        <div class="card">
                                            <div class="card-content">
                                                <img class="card-img-top img-fluid"
                                                     src="https://picsum.photos/seed/picsum/200/300"
                                                     alt="Card image cap"
                                                     style="height: 6rem;"
                                                >
                                                <div class="mt-1 text-center">
                                                    <h4 class="card-title">Card title</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3 col-lg-3 product-list">
                                        <div class="card">
                                            <div class="card-content">
                                                <img class="card-img-top img-fluid"
                                                     src="https://picsum.photos/seed/picsum/200/300"
                                                     alt="Card image cap"
                                                     style="height: 6rem;"
                                                >
                                                <div class="mt-1 text-center">
                                                    <h4 class="card-title">Card title</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3 col-lg-3 product-list">
                                        <div class="card">
                                            <div class="card-content">
                                                <img class="card-img-top img-fluid"
                                                     src="https://picsum.photos/seed/picsum/200/300"
                                                     alt="Card image cap"
                                                     style="height: 6rem;"
                                                >
                                                <div class="mt-1 text-center">
                                                    <h4 class="card-title">Card title</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3 col-lg-3 product-list">
                                        <div class="card">
                                            <div class="card-content">
                                                <img class="card-img-top img-fluid"
                                                     src="https://picsum.photos/seed/picsum/200/300"
                                                     alt="Card image cap"
                                                     style="height: 6rem;"
                                                >
                                                <div class="mt-1 text-center">
                                                    <h4 class="card-title">Card title</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3 col-lg-3 product-list">
                                        <div class="card">
                                            <div class="card-content">
                                                <img class="card-img-top img-fluid"
                                                     src="https://picsum.photos/seed/picsum/200/300"
                                                     alt="Card image cap"
                                                     style="height: 6rem;"
                                                >
                                                <div class="mt-1 text-center">
                                                    <h4 class="card-title">Card title</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3 col-lg-3 product-list">
                                        <div class="card">
                                            <div class="card-content">
                                                <img class="card-img-top img-fluid"
                                                     src="https://picsum.photos/seed/picsum/200/300"
                                                     alt="Card image cap"
                                                     style="height: 6rem;"
                                                >
                                                <div class="mt-1 text-center">
                                                    <h4 class="card-title">Card title</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3 col-lg-3 product-list">
                                        <div class="card">
                                            <div class="card-content">
                                                <img class="card-img-top img-fluid"
                                                     src="https://picsum.photos/seed/picsum/200/300"
                                                     alt="Card image cap"
                                                     style="height: 6rem;"
                                                >
                                                <div class="mt-1 text-center">
                                                    <h4 class="card-title">Card title</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3 col-lg-3 product-list">
                                        <div class="card">
                                            <div class="card-content">
                                                <img class="card-img-top img-fluid"
                                                     src="https://picsum.photos/seed/picsum/200/300"
                                                     alt="Card image cap"
                                                     style="height: 6rem;"
                                                >
                                                <div class="mt-1 text-center">
                                                    <h4 class="card-title">Card title</h4>
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
            <div class="col-md-12">
                <button class="btn btn-info btn-md"> Draft</button>
                <button class="btn btn-warning btn-md">Quatation</button>
            </div>
        </div>
    </section>

</div>
@endsection

@section('pageJs')
<script src="{{ asset('assets/vendors/js/pickers/pickadate/picker.js') }}"></script>
<script src="{{ asset('assets/vendors/js/pickers/pickadate/picker.date.js') }}"></script>
<script src="{{ asset('assets/vendors/js/animation/jquery.appear.js') }}"></script>

<script>
    $(document).ready(function () {
        var cat_id = '';
        var brand_id='';
        var productList=[];
        getProducts();

        $('#category_id').on('change', function (e) {
            cat_id = e.target.value;
            getProducts();
        });
        $('#brand_id').on('change', function (e) {
            brand_id = e.target.value;
            getProducts();
        });
        $('#BCS_products_container').on('click', '.product-list', function (e) {
            console.log($(this).data('product-idx'));
            console.log(productList[$(this).data('product-idx')]);
        });
        function getProducts(){
            $('#BCS_loader').show();
            $('#BCS_message').hide();
            $('#BCS_products').hide();
            $.ajax({
                url: "{{ route('ajax.get.products') }}",
                cache: true,
                dataType: 'json',
                delay: 250,
                data: {
                    category_id: cat_id, // search term
                    brand_id: brand_id
                },
                success: function (response) {
                    $('#BCS_loader').hide();
                    console.log(response);
                    if(response.status == 200){
                        if(response.data && response.data.length > 0){
                            productList = response.data;
                            $('#BCS_products').find('.ex1').html('');
                            let productListHtml = '';
                            response.data.forEach((product, index)=>{
                                productListHtml += `<div class="col-sm-12 col-md-3 col-lg-3 product-list"
                                                    data-product-idx="${index}"
                                                    data-appear="appear" data-animation="slideInUp">
                                        <div class="card">
                                            <div class="card-content">
                                                <img class="product-img"
                                                     src="${product.attachment.image_path}"
                                                     alt="${product.product_reference}"
                                                >
                                                <div class="mt-1 text-center">
                                                    <h4 class="card-title">${product.product_reference}</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>`;
                            });
                            $('#BCS_products').find('.ex1').html(productListHtml);
                            $('#BCS_products').show();
                        }else{
                            $('#BCS_message').show();
                            $('#BCS_message').find('#msg').html('No Product Found');
                        }
                    }else{
                        $('#BCS_message').show();
                        $('#BCS_message').find('#msg').html('Something Wrong! try again');
                    }

                },
            });
        }
    });

</script>
@endsection
{{-- /*
* Author: Arup Kumer Bose
* Email: arupkumerbose@gmail.com
* Company Name: Brainchild Software <brainchildsoft@gmail.com>
*/ --}}
