@extends('layouts.app')

@section('pageTitle', 'Brand')

@section('pageCss')

@endsection

@section('pageContent')
    <div class="content-wrapper">
        <div class="content-header row">
            <?php
                $breadcrumbs = [
                    'Brand' => 'Brand'
                ];
            ?>
            @include('layouts.includes.breadcrumb', $breadcrumbs)
        </div>
        <div class="content-body">
            <section class="row">
                <div class="col-4">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" id="basic-layout-form">{{ !empty($brand)? 'Update': 'Create New' }} Brand Information</h4>
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
                                @if(!empty($brand))
                                <form class="form GlobalFormValidation" method="post" action="{{ route('brand.update', $brand->brand_id) }}" >
                                    @method('PUT')
                                @else
                                <form class="form GlobalFormValidation" method="post" action="{{ route('brand.store') }}">
                                @endif
                                    @csrf
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="projectinput1">Brand Name <b class="font-weight-bold text-warning">*</b> </label>
                                                    <input type="text" id="projectinput1"
                                                           class="form-control"
                                                           name="brand_name"
                                                           value="{{ !empty($brand)? $brand->brand_name: '' }}"
                                                           placeholder="Brand Name"
                                                           data-fv-notempty='true'
                                                           data-fv-blank='true'
                                                           data-rule-required='true'
                                                           data-fv-notempty-message='Brand Name Is Required'
                                                    >
                                                </div>
                                                <div class="form-group">
                                                    <label>Brand Status <b class="font-weight-bold text-warning">*</b></label>
                                                    <div class="input-group">
                                                        <div class="d-inline-block custom-control custom-radio mr-1">
                                                            <input type="radio" name="status"
                                                               value="{{ config('constant.active') }}"
                                                               class="custom-control-input" id="yes1"
                                                                   {{ empty($brand) || $brand->status == 1 ? 'checked': '' }}
                                                               >
                                                            <label class="custom-control-label" for="yes1">Active</label>
                                                        </div>
                                                        <div class="d-inline-block custom-control custom-radio">
                                                            <input type="radio" name="status"
                                                                   value="{{ config('constant.inactive') }}"
                                                                   class="custom-control-input" id="no1"
                                                                {{ !empty($brand) && $brand->status == 2 ? 'checked': '' }}
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
                                        <a href="{{ !empty($brand)? route('brand.index'): '#' }}" class="btn btn-warning mr-1 {{ empty($brand)? 'resetBtn': '' }} btn-glow">
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
                                <h4 class="card-title">Brand List</h4>
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
                                            <th>Brand Name</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(!empty($brands) && count($brands) > 0)
                                            @foreach($brands as $brand)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $brand->brand_name }}</td>
                                                    <td class="text-center">
                                                        @if($brand->status == 1)
                                                            <span class="badge badge-success badge-md">Active</span>
                                                        @else
                                                            <span class="badge badge-warning badge-md">Inactive</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="btn-group" role="group" aria-label="Basic example">
                                                            <a href="{{ route('brand.edit', $brand->brand_id) }}" class="btn btn-info btn-glow"><i class="la la-edit"></i> Edit</a>
                                                            <button type="button" class="btn btn-danger btn-glow"><i class="la la-trash"></i> Delete</button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                {{ $brands->links() }}
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
