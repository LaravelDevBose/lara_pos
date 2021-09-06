@extends('layouts.app')

@section('pageTitle', 'Unite')

@section('pageCss')

@endsection

@section('pageContent')
    <div class="content-wrapper">
        <div class="content-header row">
            <?php
                $breadcrumbs = [
                    'Unit' => 'Unite'
                ];
            ?>
            @include('layouts.includes.breadcrumb', $breadcrumbs)
        </div>
        <div class="content-body">
            <section class="row">
                <div class="col-4">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" id="basic-layout-form">{{ !empty($unit)? 'Update': 'Create New' }} Unit Information</h4>
                            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body">
                                @if(!empty($unit))
                                <form class="form GlobalFormValidation" method="post" action="{{ route('units.update', $unit->unit_id) }}" >
                                    @method('PUT')
                                @else
                                <form class="form GlobalFormValidation" method="post" action="{{ route('units.store') }}">
                                @endif
                                    @csrf
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="projectinput1">Unit Name <b class="font-weight-bold text-warning">*</b> </label>
                                                    <input type="text" id="projectinput1"
                                                           class="form-control"
                                                           name="unit_name"
                                                           value="{{ !empty($unit) ? $unit->unit_name: '' }}"
                                                           placeholder="Unit Name"
                                                           data-fv-notempty='true'
                                                           data-fv-blank='true'
                                                           data-rule-required='true'
                                                           data-fv-notempty-message='Unit Name Is Required'
                                                    >
                                                </div>

                                                <div class="form-group">
                                                    <label for="projectinput1">Sort Form <b class="font-weight-bold text-warning">*</b> </label>
                                                    <input type="text" id="projectinput1"
                                                           class="form-control"
                                                           name="sort_form"
                                                           value="{{ !empty($unit) ? $unit->sort_form: '' }}"
                                                           placeholder="Sort Form"
                                                           data-fv-notempty='true'
                                                           data-fv-blank='true'
                                                           data-rule-required='true'
                                                           data-fv-notempty-message='Sort Form Is Required'
                                                    >
                                                </div>

                                                <div class="form-group">
                                                    <label>Unit Status <b class="font-weight-bold text-warning">*</b></label>
                                                    <div class="input-group">
                                                        <div class="d-inline-block custom-control custom-radio mr-1">
                                                            <input type="radio" name="status"
                                                               value="{{ config('constant.active') }}"
                                                               class="custom-control-input" id="yes1"
                                                                   {{ empty($unit) || $unit->status == 1 ? 'checked': '' }}
                                                               >
                                                            <label class="custom-control-label" for="yes1">Active</label>
                                                        </div>
                                                        <div class="d-inline-block custom-control custom-radio">
                                                            <input type="radio" name="status"
                                                                   value="{{ config('constant.inactive') }}"
                                                                   class="custom-control-input" id="no1"
                                                                {{ !empty($unit) && $unit->status == 2 ? 'checked': '' }}
                                                            >
                                                            <label class="custom-control-label" for="no1">Inactive</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                @include('layouts.includes.alert_messages')
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-actions text-right">
                                        <a href="{{ !empty($unit)? route('units.index'): '#' }}" class="btn btn-warning mr-1 {{ empty($unit)? 'resetBtn': '' }} btn-glow">
                                            <i class="ft-x"></i> Cancel
                                        </a>
                                        <button type="submit" class="btn btn-success btn-glow">
                                            <i class="la la-check-square-o"></i> Save
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-8">
                    <div class="card">
                        <div class="card-head">
                            <div class="card-header">
                                <h4 class="card-title">Unit List</h4>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <!-- Invoices List table -->
                                <div class="table-responsive">
                                    <table class="table table-striped table-white-space table-bordered display no-wrap table-middle">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Unit Name</th>
                                            <th>Sort Form</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(!empty($units) && count($units) > 0)
                                            @foreach($units as $unit)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $unit->unit_name }}</td>
                                                    <td>{{ $unit->sort_form }}</td>
                                                    <td class="text-center">
                                                        @if($unit->status == 1)
                                                            <span class="badge badge-success badge-md">Active</span>
                                                        @else
                                                            <span class="badge badge-warning badge-md">Inactive</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="btn-group" role="group" aria-label="Basic example">
                                                            <a href="{{ route('units.edit', $unit->unit_id) }}" class="btn btn-info btn-glow"><i class="la la-edit"></i> Edit</a>
                                                            <form action="{{ url('units/'.$unit->unit_id) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-glow"><i class="la la-trash"></i> Delete</button>
                                                            </form>

                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                {{ $units->links() }}
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

@endsection
{{--/*--}}
{{--* Author: Arup Kumer Bose--}}
{{--* Email: arupkumerbose@gmail.com--}}
{{--* Company Name: Brainchild Software--}}
{{--<brainchildsoft@gmail.com>--}}
{{--*/--}}
