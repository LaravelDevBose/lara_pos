@extends('layouts.app')

@section('pageTitle', 'Add New Sell')

@section('pageCss')
<link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/pickers/pickadate/pickadate.css')}}">
<style>
    .select2.select2-container {
        width: 90% !important;
    }

    div.ex1 {
        height: 490px;
        width: 100%;
        overflow: auto;
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
                                                @foreach ($customers as $item)
                                                <option value="">--Select Customer--</option>
                                                <option value="{{ $item->contact_id }}"> {{ $item->first_name}}
                                                </option>
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


                                <div style="margin-top: 40px">
                                    <button class="btn btn-info btn-sm"><i class="text-light h4 ft-edit"></i>
                                        Draft</button>
                                    <button class="btn btn-warning btn-sm"><i class="text-light h4 ft-edit"></i>
                                        Quatation</button>
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
                            <div class="input-group">
                                <select class="select2 form-control " name="category_id" id="category_id">
                                    @foreach ($categories as $item)
                                    <option value="">--Select Category--</option>
                                    <option value="{{ $item->category_id }}"> {{ $item->category_name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="input-group">
                                <select class="select2 form-control " name="brand_id" id="brand_id">
                                    @foreach ($brands as $item)
                                    <option value="">--Select Brand--</option>
                                    <option value="{{ $item->brand_id }}"> {{ $item->brand_name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row ex1">
                    <div class="col-sm-12 col-md-3 col-lg-3">
                        <div class="card" style="width: 7.8rem">
                            <div class="card-content">
                                <img class="card-img-top img-fluid" src="https://picsum.photos/seed/picsum/200/300" alt="Card image cap">
                                <div class="mt-1 text-center">
                                    <h4 class="card-title">Card title</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-3 col-lg-3">
                        <div class="card" style="width: 7.8rem">
                            <div class="card-content">
                                <img class="card-img-top img-fluid" src="https://picsum.photos/seed/picsum/200/300" alt="Card image cap">
                                <div class="mt-1 text-center">
                                    <h4 class="card-title">Card title</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-3 col-lg-3">
                        <div class="card" style="width: 7.8rem">
                            <div class="card-content">
                                <img class="card-img-top img-fluid" src="https://picsum.photos/seed/picsum/200/300" alt="Card image cap">
                                <div class="mt-1 text-center">
                                    <h4 class="card-title">Card title</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-3 col-lg-3">
                        <div class="card" style="width: 7.8rem">
                            <div class="card-content">
                                <img class="card-img-top img-fluid" src="https://picsum.photos/seed/picsum/200/300" alt="Card image cap">
                                <div class="mt-1 text-center">
                                    <h4 class="card-title">Card title</h4>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-sm-12 col-md-3 col-lg-3">
                        <div class="card" style="width: 7.8rem">
                            <div class="card-content">
                                <img class="card-img-top img-fluid" src="https://picsum.photos/seed/picsum/200/300" alt="Card image cap">
                                <div class="mt-1 text-center">
                                    <h4 class="card-title">Card title</h4>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-sm-12 col-md-3 col-lg-3">
                        <div class="card" style="width: 7.8rem">
                            <div class="card-content">
                                <img class="card-img-top img-fluid" src="https://picsum.photos/seed/picsum/200/300" alt="Card image cap">
                                <div class="mt-1 text-center">
                                    <h4 class="card-title">Card title</h4>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-sm-12 col-md-3 col-lg-3">
                        <div class="card" style="width: 7.8rem">
                            <div class="card-content">
                                <img class="card-img-top img-fluid" src="https://picsum.photos/seed/picsum/200/300" alt="Card image cap">
                                <div class="mt-1 text-center">
                                    <h4 class="card-title">Card title</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-3 col-lg-3">
                        <div class="card" style="width: 7.8rem">
                            <div class="card-content">
                                <img class="card-img-top img-fluid" src="https://picsum.photos/seed/picsum/200/300" alt="Card image cap">
                                <div class="mt-1 text-center">
                                    <h4 class="card-title">Card title</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-3 col-lg-3">
                        <div class="card" style="width: 7.8rem">
                            <div class="card-content">
                                <img class="card-img-top img-fluid" src="https://picsum.photos/seed/picsum/200/300" alt="Card image cap">
                                <div class="mt-1 text-center">
                                    <h4 class="card-title">Card title</h4>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </section>

</div>
@endsection

@section('pageJs')
<script src="{{ asset('assets/vendors/js/pickers/pickadate/picker.js') }}"></script>
<script src="{{ asset('assets/vendors/js/pickers/pickadate/picker.date.js') }}"></script>

<script>

</script>
@endsection
{{-- /*
* Author: Arup Kumer Bose
* Email: arupkumerbose@gmail.com
* Company Name: Brainchild Software <brainchildsoft@gmail.com>
*/ --}}
