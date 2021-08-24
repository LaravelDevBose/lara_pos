@extends('layouts.app')

@section('pageTitle', !empty($product)? 'Update product':'Add new product')

@section('pageCss')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/pickers/pickadate/pickadate.css')}}">

    <style>
        .custom-file-label::after {
            color: #ffffff;
            background-color: #7b4bda;
        }
    </style>
@endsection

@section('pageContent')
    <div class="content-wrapper">
        <div class="content-header row">
            <?php
            $breadcrumbs = [
                'Product List' => route('products.index'),
                'Product Create' => !empty($product)? 'Update product':'Add new product'
            ];

            ?>
            @include('layouts.includes.breadcrumb', $breadcrumbs)
        </div>
        <div class="content-body">
            @if(!empty($product))
                <form class="form GlobalFormValidation" method="post" action="{{ route('products.update', $product->expense_id) }}" >
                @method('PUT')
            @else
                <form class="form GlobalFormValidation" method="post" action="{{ route('products.store') }}">
            @endif
            @csrf
                <section class="users-edit">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>Category <b class="font-weight-bold text-warning">*</b></label>
                                                <select class="select2 form-control" name="category_id"
                                                        data-fv-notempty='true'
                                                        data-fv-blank='true'
                                                        data-rule-required='true'
                                                        data-fv-notempty-message='Category Is Required'
                                                        required
                                                >
                                                    <option value=" ">Select a Category</option>
                                                    @if(!empty($categories) && count($categories) > 0)
                                                        @foreach($categories as $category)
                                                            <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                                                            @foreach ($category->children as $child)
                                                                <option value="{{ $child->category_id }}">-{{ $child->category_name }}</option>
                                                            @endforeach
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>Brand <b class="font-weight-bold text-warning">*</b></label>
                                                <select class="select2 form-control" name="brand_id"
                                                        data-fv-notempty='true'
                                                        data-fv-blank='true'
                                                        data-rule-required='true'
                                                        data-fv-notempty-message='Brand Is Required'
                                                        required
                                                >
                                                    <option value=" ">Select a Brand</option>
                                                    @if(!empty($brands) && count($brands) > 0)
                                                        @foreach($brands as $brandId=> $brandname)
                                                            <option value="{{ $brandId }}">{{ $brandname }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>Artical Reference <b class="font-weight-bold text-warning">*</b></label>
                                                <input type="text" class="form-control"
                                                       name="reference_no"
                                                       value="{{ !empty($product)? $product->total_amount: '' }}"
                                                       placeholder="Artical Reference"
                                                       data-fv-notempty='true'
                                                       data-fv-blank='true'
                                                       data-rule-required='true'
                                                       data-fv-notempty-message='Artical Reference Is Required'
                                                       required
                                                >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>Short Description<b class="font-weight-bold text-warning">*</b></label>
                                                <input type="text" class="form-control"
                                                       name="reference_no"
                                                       value="{{ !empty($product)? $product->total_amount: '' }}"
                                                       placeholder="Short Description"
                                                       data-fv-notempty='true'
                                                       data-fv-blank='true'
                                                       data-rule-required='true'
                                                       data-fv-notempty-message='Short Description Is Required'
                                                       required
                                                >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>Expense For</label>
                                                <select class="select2 form-control" name="expense_for"
                                                >
                                                    <option value=" ">Select a Expense For</option>
                                                    @if(!empty($employees) && count($employees) > 0)
                                                        @foreach($employees as $id => $name)
                                                            <option value="{{ $id }}">{{ $name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>Total amount <b class="font-weight-bold text-warning">*</b></label>
                                                <input type="text" class="form-control"
                                                       name="total_amount"
                                                       value="{{ !empty($product)? $product->total_amount: '' }}"
                                                       placeholder="Total amount"
                                                       step="0.01"
                                                       data-fv-notempty='true'
                                                       data-fv-blank='true'
                                                       data-rule-required='true'
                                                       data-fv-notempty-message='Total amount Is Required'
                                                       required
                                                >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label for="attachment">Attach Document</label>
                                                <div class="custom-file">
                                                    <input type="file" name="attachment" class="custom-file-input" id="attachment" accept="application/pdf,text/csv,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,image/jpeg,image/jpg,image/png">
                                                    <label class="custom-file-label" for="attachment" aria-describedby="inputGroupFile02">Choose file</label>
                                                </div>
                                            </div>
                                            <small class="text-help">Max File Size: 1MB</small> <br>
                                            <small class="text-help">Allowed File: .pdf, .csv, .doc, .docx, .jpeg, .jpg, .png</small>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>Expense Note</label>
                                                <textarea name="expense_note" rows="2" class="form-control" placeholder="Expense note..">{{ !empty($product)? $product->expense_note: '' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </form>
        </div>
    </div>
@endsection

@section('pageJs')
    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('assets/vendors/js/pickers/pickadate/picker.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/pickers/pickadate/picker.date.js') }}"></script>
    <!-- END: Page Vendor JS-->
    <script>
        $(document).ready(function () {
            $('.pickadate').pickadate({
                format: 'mm/d/yyyy',
                formatSubmit: 'mm/dd/yyyy',
            });

            $('#paymentMethodChange').on('change', function (e) {
                $('#cardInfo').hide();
                $('#chequeInfo').hide();
                $('#bankInfo').hide();
                if(e.target.value == {{ \App\Models\Transaction::Methods['Card'] }}){
                    $('#cardInfo').show();
                }else if(e.target.value == {{ \App\Models\Transaction::Methods['Cheque'] }}){
                    $('#chequeInfo').show();
                }else if(e.target.value == {{ \App\Models\Transaction::Methods['Bank Transfer'] }}){
                    $('#bankInfo').show();
                }
            });
        });

    </script>
@endsection
{{-- /*
* Author: Arup Kumer Bose
* Email: arupkumerbose@gmail.com
* Company Name: Brainchild Software <brainchildsoft@gmail.com>
*/ --}}
