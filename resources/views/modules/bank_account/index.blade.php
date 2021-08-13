@extends('layouts.app')

@section('pageTitle', 'Account list')

@section('pageCss')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
@endsection

@section('pageContent')
    <div class="content-wrapper">
        <div class="content-header row">
            <?php
                $breadcrumbs = [
                    'Account list' => 'Account list'
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
                                <h4 class="card-title">Account list</h4>
                                <div class="heading-elements mt-0">
                                    <a href="{{ route('bank_accounts.create') }}" class="btn btn-primary btn-sm ">
                                        <i class="d-md-none d-block ft-plus white"></i>
                                        <span class="d-md-block d-none">Add Accounts</span>
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
                                    <table id="BCSDataTable" class="table table-striped table-white-space table-bordered display no-wrap icheck table-middle">
                                        <thead>
                                        <tr>
                                            <th class="text-center">Actions</th>
                                            <th>Person Name</th>
                                            <th>Account number</th>
                                            <th>Account Type</th>
                                            <th class="text-right">Opening Balance</th>
                                            <th>Account Details</th>
                                            <th>Note</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @if(!empty($accounts) && count($accounts) > 0)
                                                @foreach($accounts as $account)
                                                    <tr>
                                                        <td class="text-center">
                                                            <span class="dropdown">
                                                                <a id="btnSearchDrop2" href="#" title="Action" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="dropdown-toggle dropdown-menu-right btn btn-info btn-sm"><i class="la la-cogs"></i></a>
                                                                <span aria-labelledby="btnSearchDrop2" class="dropdown-menu mt-1 dropdown-menu-right">
                                                                    <a  href="{{ route('bank_accounts.edit', $account->bank_acc_id) }}"  title="Edit" class="dropdown-item"><i class="ft-edit-2"></i> Edit </a>
                                                                </span>
                                                            </span>
                                                        </td>
                                                        <td>{{ $account->acc_holder_name }}</td>
                                                        <td>{{ $account->account_number }}</td>
                                                        <td>{{ $account->account_class }}</td>
                                                        <td class="text-right">{{ $account->opening_balance }}</td>
                                                        <td>
                                                            @if(!empty($account->account_details))
                                                                <ul>
                                                                    @foreach($account->account_details as $details)
                                                                    <li>
                                                                        {{ !empty($details['label'])? $details['label'].' : ': '' }} {{ !empty($details['value'])? $details['value']: '' }}
                                                                    </li>
                                                                    @endforeach
                                                                </ul>
                                                            @endif
                                                        </td>
                                                        <td>{{ $account->account_note }}</td>
                                                        <td class="text-center">
                                                            @if($account->status == 1)
                                                                <span class="badge badge-success badge-md">Active</span>
                                                            @else
                                                                <span class="badge badge-warning badge-md">Inactive</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
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
            $("#BCSDataTable").DataTable({
                searching:  true,
                responsive: true,
                columnDefs: [
                    { orderable: false, targets: 0 }
                ],
                columns: [
                    {searchable: false, orderable: false},
                    null,
                    null,
                    null,
                    null,
                    {orderable: false},
                    {orderable: false},
                    {searchable: false},
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
