@extends('layouts.app')

@section('pageTitle', !empty($_GET['type'])? ucfirst($_GET['type']).' list': 'Contact list')

@section('pageCss')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
@endsection

@section('pageContent')
    <div class="content-wrapper">
        <div class="content-header row">
            <?php
            if (!empty($_GET['type']) && $_GET['type'] == 'customer'){
                $breadcrumbs = [
                    'Customer list' => 'Customer list'
                ];
            }else{
                $breadcrumbs = [
                    'Supplier list' => 'Supplier list'
                ];
            }

            ?>
            @include('layouts.includes.breadcrumb', $breadcrumbs)
        </div>
        <div class="content-body">
            <section class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-head">
                            <div class="card-header">
                                <h4 class="card-title">{{ !empty($_GET['type'])? ucfirst($_GET['type']): 'Contact ' }} list</h4>
                                <div class="heading-elements mt-0">
                                    <a href="{{ route('contacts.create', ['type'=>!empty($_GET['type'])? $_GET['type']: 'customer']) }}" class="btn btn-primary btn-sm ">
                                        <i class="d-md-none d-block ft-plus white"></i>
                                        <span class="d-md-block d-none">Add Contacts</span>
                                    </a>
                                    <span class="dropdown">
                                        <button id="btnSearchDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="btn btn-warning dropdown-toggle dropdown-menu-right btn-sm"><i class="ft-download-cloud white"></i></button>
                                        <span aria-labelledby="btnSearchDrop1" class="dropdown-menu mt-1 dropdown-menu-right">
                                            <a href="#" class="dropdown-item"><i class="ft-upload"></i> Import</a>
                                            <a href="#" class="dropdown-item"><i class="ft-download"></i> Export</a>
                                            <a href="#" class="dropdown-item"><i class="ft-shuffle"></i> Find Duplicate</a>
                                        </span>
                                    </span>
                                    <button class="btn btn-default btn-sm"><i class="ft-settings white"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <!-- Invoices List table -->
                                <div class="table-responsive">
                                    <table id="BCSDataTable" class="table table-striped table-white-space table-bordered display no-wrap icheck table-middle"
                                        data-url="{{ route('contacts.datatable', ['type'=>!empty($_GET['type'])? $_GET['type']: 'customer']) }}"
                                    >
                                        <thead>
                                        <tr>
                                            <th class="text-center">Actions</th>
                                            <th class="text-center">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="checkboxsmallall">
                                                    <label class="custom-control-label" for="checkboxsmallall"></label>
                                                </div>
                                            </th>
                                            <th class="text-center">Id</th>
                                            <th>Business Name</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th>Address</th>
                                            <th class="text-right">Opening Balance</th>
{{--                                            <th>Pay term</th>--}}
                                            <th class="text-right">Advance Balance</th>
                                            <th class="text-right">Total Due</th>
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
    <!-- END: Page Vendor JS-->

    <script>
        $(document).ready(function () {
            // checkbox check all on click
            $("input#checkboxsmallall").on("click", function () {
                if ($("input:checked#checkboxsmallall").length > 0) {
                    $("input:not(:checked)").prop('checked', true);
                }
                else {
                    $("input:checked").prop('checked', false);
                }
            });

            $("#BCSDataTable").DataTable({
                processing: true,
                serverSide: true,
                searching:  true,
                fixedHeader: true,
                "scrollX": true,
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
                        className: "d-none d-xl-table-cell", targets: [1,8,9,10],
                        className: "text-center", targets: [0,1,2,12],
                        className: "text-right", targets: [9,10,11],
                    }
                ],
                columns: [
                    {data: 'action', name: 'action', searchable: false, orderable: false},
                    {data: 'checkbox', name: 'checkbox',searchable: false, orderable: false},
                    {data: 'unique_code', name: 'unique_code'},
                    {data: 'business_name', name: 'business_name'},
                    {data: 'first_name', name: 'first_name'},
                    {data: 'last_name', name: 'last_name'},
                    {data: 'mobile_no', name: 'mobile_no'},
                    {data: 'email', name: 'email', searchable: false, orderable: false},
                    {data: 'address', name: 'address', searchable: false, orderable: false},
                    {data: 'open_balance', name: 'open_balance'},
                    // {data: 'pay_term', name: 'pay_term', searchable: false, orderable: false},
                    {data: 'advance_balance', name: 'advance_balance', searchable: false},
                    {data: 'total_due', name: 'total_due', searchable: false},
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
