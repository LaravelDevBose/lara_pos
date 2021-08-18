@extends('layouts.app')

@section('pageTitle', 'Business Locations')

@section('pageCss')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
@endsection

@section('pageContent')
    <div class="content-wrapper">
        <div class="content-header row">
            <?php
            $breadcrumbs = [
                'Business Locations' => 'Business Locations'
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
                                <h4 class="card-title">Business Locations</h4>
                                <div class="heading-elements mt-0">
                                    <a href="{{ route('business_locations.create') }}" class="btn btn-primary btn-sm ">
                                        <i class="d-md-none d-block ft-plus white"></i>
                                        <span class="d-md-block d-none">Add New Location</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <!-- Invoices List table -->
                                <div class="table-responsive">
                                    <table id="BCSDataTable" class="table table-sm table-white-space table-bordered table-middle">
                                        <thead>
                                        <tr>
                                            <th class="text-center">Actions</th>
                                            <th class="text-center">Id</th>
                                            <th>Business Name</th>
                                            <th>Phone</th>
                                            <th>Alt. Phone no</th>
                                            <th>Landmark</th>
                                            <th>City</th>
                                            <th>State</th>
                                            <th>Zip Code</th>
                                            <th>Country</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @if(!empty($locations) && count($locations) > 0)
                                                @foreach($locations as $location)
                                                    <tr>
                                                        <td class="text-center">
                                                            <span class="dropdown">
                                                                <a id="btnSearchDrop2" href="#" title="Action" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="dropdown-toggle dropdown-menu-right btn btn-info btn-sm"><i class="la la-cogs"></i></a>
                                                                <span aria-labelledby="btnSearchDrop2" class="dropdown-menu mt-1 dropdown-menu-right">
                                                                    <a  href="{{ route('business_locations.edit', $location->location_id) }}"  title="Edit" class="dropdown-item"><i class="ft-edit-2"></i> Edit </a>
                                                                </span>
                                                            </span>
                                                        </td>
                                                        <td class="text-center">{{ $location->location_id }}</td>
                                                        <td>{{ $location->store_name }}</td>
                                                        <td>{{ $location->phone_no }}</td>
                                                        <td>{{ $location->alt_phone_no }}</td>
                                                        <td>{{ $location->landmark }}</td>
                                                        <td>{{ $location->city }}</td>
                                                        <td>{{ $location->state }}</td>
                                                        <td>{{ $location->zipcode }}</td>
                                                        <td>{{ $location->country }}</td>
                                                        <td class="text-center">
                                                            @if($location->status == 1)
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
                processing: true,
                serverSide: false,
                searching:  true,
                columns: [
                    {searchable: false, orderable: false},
                    null,
                    null,
                    {orderable: false},
                    {orderable: false},
                    {orderable: false},
                    null,
                    null,
                    null,
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
