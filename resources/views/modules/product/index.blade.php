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
                                            <th>Image</th>
                                            <th>Product Name</th>
                                            <th>Description</th>
                                            <th>Category</th>
                                            <th>Brand</th>
                                            <th>Alert Quantity</th>
                                            <th>Product Type</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($products as $product)
                                                <tr>
                                                    <td><a href="">edit</a></td>
                                                    <td>{{ $product->product_name }}</td>
                                                    <td>{{ $product->product_name }}</td>
                                                    <td>{{ $product->short_description }}</td>
                                                    <td>{{ $product->category->category_name }}</td>
                                                    <td>{{ $product->brand->brand_name }}</td>
                                                    <td>{{ $product->alert_qty }}</td>
                                                    <td>{{ $product->product_type }}</td>
                                                </tr>
                                            @endforeach
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
                        className: "d-none d-xl-table-cell", targets: [3],
                        className: "text-center", targets: [0],
                        className: "text-right", targets: [7,8],
                    }
                ],
                columns: [
                    {data: 'action', name: 'action', searchable: false, orderable: false},
                    {data: 'image', name: 'image', searchable: false, orderable: false},
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
