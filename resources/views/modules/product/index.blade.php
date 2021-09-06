@extends('layouts.app')

@section('pageTitle', 'Product list')

@section('pageCss')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/pickers/pickadate/pickadate.css')}}">
@endsection

@section('pageContent')
    <div class="content-wrapper">
        <div class="content-header row">
            <?php
            $breadcrumbs = [
                'Product list' => 'Product list'
            ];
            ?>
            @include('layouts.includes.breadcrumb', $breadcrumbs)
        </div>
        <div class="content-body">
            <section class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-head">
                            <div class="card-header">
                                <h4 class="card-title">Product list</h4>
                                <div class="heading-elements mt-0">
                                    <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm ">
                                        <i class="d-md-none d-block ft-plus white"></i>
                                        <span class="d-md-block d-none">Add New Product</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <!-- Invoices List table -->
                                <div class="table-responsive">
                                    <table id="BCSDataTable" class="table table-striped table-white-space table-bordered table-middle"
                                           data-url="{{ route('products.datatable') }}"
                                    >
                                        <thead>
                                        <tr>
                                            <th class="text-center">Actions</th>
                                            <th class="text-center">Image</th>
{{--                                            <th>Product Code</th>--}}
                                            <th>Product Name</th>
                                            <th class="text-right">Unit Purchase price</th>
                                            <th class="text-right">Selling price</th>
                                            <th class="text-center">Product Type</th>
                                            <th>Category</th>
                                            <th>Brand</th>
                                            <th>Tax</th>
                                            <th class="text-center">Alert Quantity</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                                <!--/ Invoices table -->
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

@section('pageJs')
    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('assets/vendors/js/tables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/extensions/jquery.raty.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/pickers/pickadate/picker.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/pickers/pickadate/picker.date.js') }}"></script>
    <!-- END: Page Vendor JS-->
    <script>
        $(document).ready(function () {
            $("#BCSDataTable").DataTable({
                processing: true,
                serverSide: true,
                searching:  true,
                fixedHeader: true,
                ajax: {
                    url: $("#BCSDataTable").attr('data-url'),
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                },
                columnDefs: [
                    {
                        className: "d-none d-xl-table-cell", targets: [6,7,8,9],
                        className: "text-center", targets: [0,1,5,9,10],
                        className: "text-right", targets: [3,4],
                    }
                ],
                columns: [
                    {data: 'action', name: 'action', searchable: false, orderable: false},
                    {data: 'image', name: 'image', searchable: false, orderable: false},
                    // {data: 'product_code', name: 'product_code'},
                    {data: 'product_name', name: 'product_name'},
                    {data: 'product_dpp_inc_tax', name: 'product_dpp_inc_tax'},
                    {data: 'product_dsp', name: 'product_dsp'},
                    {data: 'product_type', name: 'product_type'},
                    {data: 'category_id', name: 'category_id'},
                    {data: 'brand_id', name: 'brand_id'},
                    {data: 'tax_id', name: 'tax_id'},
                    {data: 'alert_qty', name: 'alert_qty'},
                    {data: 'status', name: 'status'},
                ]
            });
        });
    </script>
@endsection
{{-- /*
* Author: Arup Kumer Bose
* Email: arupkumerbose@gmail.com
* Company Name: Brainchild Software <brainchildsoft@gmail.com>
*/ --}}
