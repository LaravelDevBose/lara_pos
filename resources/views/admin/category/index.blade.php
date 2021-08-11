@extends('layouts.app')

@section('pageTitle', 'Category')

@section('pageCss')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/forms/selects/selectivity-full.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/plugins/forms/selectivity/selectivity.css') }}">
    <style>
        .selectivity-single-select{
            padding: 0!important;
        }
    </style>
@endsection

@section('pageContent')
    <div class="content-wrapper">
        <div class="content-header row">
            <?php
            $breadcrumbs = [
                'Category' => 'Category'
            ];
            ?>
            @include('layouts.includes.breadcrumb', $breadcrumbs)
        </div>
        <div class="content-body">
            <section class="row">
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" id="basic-layout-form">{{ !empty($category)? 'Update': 'Create New' }} Category Information</h4>
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
                                @if(!empty($category))
                                    <form class="form GlobalFormValidation" method="post" action="{{ route('category.update', $category->category_id) }}" >
                                        @method('PUT')
                                @else
                                    <form class="form GlobalFormValidation" method="post" action="{{ route('category.store') }}">
                                @endif
                                    @csrf
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="projectinput1">Category Name <b class="font-weight-bold text-warning">*</b> </label>
                                                    <input type="text" id="projectinput1"
                                                           class="form-control"
                                                           name="category_name"
                                                           value="{{ !empty($category)? $category->category_name: '' }}"
                                                           placeholder="Category Name"
                                                           data-fv-notempty='true'
                                                           data-fv-blank='true'
                                                           data-rule-required='true'
                                                           data-fv-notempty-message='Category Name Is Required'
                                                    >
                                                </div>
                                                <fieldset class="form-group">
                                                    <label for="single-select-box">Parent Category</label>
                                                    <p class="text-info">if you add sub Category then select a parent Category only</p>
                                                    <select class="single-select-box selectivity-input form-control py-0"
                                                            id="single-select-box" data-placeholder="No Parent Category selected"
                                                            name="parent_id"
                                                    >
                                                        <option value=" ">Select Parent</option>
                                                        @foreach($parents as $catId=>$catName)
                                                        <option value="{{ $catId }}"
                                                            {{ !empty($category) && $category->parent_id == $catId ? 'selected': '' }}
                                                        >{{ $catName }}</option>
                                                        @endforeach
                                                    </select>
                                                </fieldset>
                                                <div class="form-group">
                                                    <label>Category Status <b class="font-weight-bold text-warning">*</b></label>
                                                    <div class="input-group">
                                                        <div class="d-inline-block custom-control custom-radio mr-1">
                                                            <input type="radio" name="status"
                                                                   value="{{ config('constant.active') }}"
                                                                   class="custom-control-input" id="yes1"
                                                                {{ empty($category) || $category->status == 1 ? 'checked': '' }}
                                                            >
                                                            <label class="custom-control-label" for="yes1">Active</label>
                                                        </div>
                                                        <div class="d-inline-block custom-control custom-radio">
                                                            <input type="radio" name="status"
                                                                   value="{{ config('constant.inactive') }}"
                                                                   class="custom-control-input" id="no1"
                                                                {{ !empty($category) && $category->status == 2 ? 'checked': '' }}
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
                                        <a href="{{ !empty($category)? route('category.index'): '#' }}" class="btn btn-warning mr-1 {{ empty($category)? 'resetBtn': '' }} btn-glow">
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
                <div class="col-sm-12 col-md-6 col-lg-8">
                    <div class="card">
                        <div class="card-head">
                            <div class="card-header">
                                <h4 class="card-title">Category List</h4>
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
                                            <th>Category Name</th>
                                            <th>Parent Name</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(!empty($categories) && count($categories) > 0)
                                            @foreach($categories as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item->category_name }}</td>
                                                    <td>{{ !empty($item->parent)? $item->parent->category_name: '' }}</td>
                                                    <td class="text-center">
                                                        @if($item->status == 1)
                                                            <span class="badge badge-success badge-md">Active</span>
                                                        @else
                                                            <span class="badge badge-warning badge-md">Inactive</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="btn-group" role="group" aria-label="Basic example">
                                                            <a href="{{ route('category.edit', $item->category_id) }}" class="btn btn-info btn-glow"><i class="la la-edit"></i> Edit</a>
                                                            <button type="button" class="btn btn-danger btn-glow"><i class="la la-trash"></i> Delete</button>
                                                        </div>
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
    <script src="{{ asset('assets/vendors/js/ui/jquery.sticky.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/forms/select/selectivity-full.min.js') }}"></script>
    <!-- END: Page Vendor JS-->
    <script src="{{ asset('assets/js/scripts/forms/select/form-selectivity.js') }}"></script>
@endsection
{{--/*--}}
{{--* Author: Arup Kumer Bose--}}
{{--* Email: arupkumerbose@gmail.com--}}
{{--* Company Name: Brainchild Software--}}
{{--<brainchildsoft@gmail.com>--}}
{{--*/--}}
