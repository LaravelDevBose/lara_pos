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
                                            <th>Reference</th>
                                            <th>Description</th>
                                            <th>Category</th>
                                            <th>Brand</th>
                                            <th>TVA</th>
                                            <th class="text-right">Min Stock</th>
                                            <th class="text-right">Max Stock</th>
                                            <th>Product Type</th>
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
                responsive: true,
                fixedColumns: {
                    leftColumns: 1,
                    rightColumns: 1
                },
                ajax: {
                    url: $("#BCSDataTable").attr('data-url'),
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                },
                columnDefs: [
                    {
                        className: "d-none d-xl-table-cell", targets: [2],
                        className: "text-center", targets: [0,8],
                        className: "text-right", targets: [6, 7],
                    }
                ],
                columns: [
                    {data: 'action', name: 'action', searchable: false, orderable: false},
                    {data: 'product_reference', name: 'product_reference'},
                    {data: 'short_description', name: 'short_description', orderable: false},
                    {data: 'category_id', name: 'category_id'},
                    {data: 'brand_id', name: 'brand_id'},
                    {data: 'product_tva', name: 'product_tva'},
                    {data: 'min_stock', name: 'min_stock'},
                    {data: 'max_stock', name: 'max_stock'},
                    {data: 'product_type', name: 'product_type'},
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
