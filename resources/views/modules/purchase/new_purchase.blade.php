@extends('layouts.app')

@section('pageTitle', 'New Purchase')

@section('pageCss')
<link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/pickers/pickadate/pickadate.css')}}">
@endsection

@section('pageContent')
<div class="content-wrapper">
    <div class="content-header row">
        <?php
            $breadcrumbs = [
                'Purchese List' => route('purchases.index'),
                'Purchese Create' => 'Add new purchese'
            ];

            ?>
            @include('layouts.includes.breadcrumb', $breadcrumbs)

    </div>

    <div>
        <div class="col-sm-12 col-md-4">
            <div class="form-group">
                <div class="controls">
                    <div class="form-group">
                        <div class="controls">
                            <label>Business Location:* <b class="font-weight-bold text-warning">*</b></label>
                            <select class="select2 form-control " name="businessLocation_id" id="">
                                @foreach ($businessLocations as $item)
                                <option value="">Please Select</option>
                                <option value="{{ $item->id }}"> {{ $item->store_name}}
                                </option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end bussiness location -->

    <div class="content-body">
        <section class="users-edit">
            <div class="card">
                <div class="card-content">
                    <form class="form GlobalFormValidation" method="post" action="{{ url('purchase.store') }}">
                        @csrf
                        <div class="card-body">
                            <!-- users edit account form start -->

                            <div class="row">
                                <div class="col-sm-12 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>Supplier: <b class="font-weight-bold text-warning">*</b></label>
                                                <select class="select2 form-control" name="supplier_id" id="supplier_id">
                                                    @foreach ($suppliers as $item)
                                                    <option value="">Please Select</option>
                                                    <option value="{{ $item->contact_id }}"> {{ $item->first_name}} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <P id="details"> </P>
                                </div>

                                <div class="col-sm-12 col-md-8 col-lg-8">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <div class="controls">
                                                    <label>Reference No:</label>
                                                    <input type="text" class="form-control" placeholder="Reference No" name="reference_no" value="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label>Date <b class="font-weight-bold text-warning">*</b></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <span class="la la-calendar-o"></span>
                                                            </span>
                                                    </div>
                                                    <input type='text' class="form-control pickadate datepicker" placeholder="select date"
                                                           name="expense_date"
                                                           value="{{ !empty($expense)? $expense->date: now()->format('m/d/Y') }}"
                                                           data-fv-notempty='true'
                                                           data-fv-blank='true'
                                                           data-rule-required='true'
                                                           data-fv-notempty-message='Date Is Required'
                                                           required
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <label for="">Pay term:</label>
                                            <div class="input-group form-group">

                                                <input type="text" class="form-control" placeholder="Dropdown on right">
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Please Select
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="#">Months</a>
                                                        <a class="dropdown-item" href="#">Days</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <div class="controls">
                                                    <label for="attachment">Attach Document:  @if(!empty($product) && !empty($product->attachment)) @else <b class="font-weight-bold text-warning">*</b>@endif</label>
                                                    <div class="flex">
                                                        <div class="input-group">
                                                            <div style="width: 100%;">
                                                                <div class="custom-file">
                                                                    <input type="file" name="image_path" class="custom-file-input file-input"
                                                                           id="attachment" accept="application/pdf,text/csv,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,image/jpeg,image/jpg,image/png"
                                                                           @if(empty($product) || empty($product->attachment))
                                                                           data-fv-notempty='true'
                                                                           data-fv-blank='true'
                                                                           data-rule-required='true'
                                                                           data-fv-notempty-message='Attach Document Is Required'
                                                                           required
                                                                           @endif
                                                                    >
                                                                    <label class="custom-file-label" for="attachment" aria-describedby="inputGroupFile02">Choose file</label>
                                                                </div>
                                                            </div>
                                                            <p class="text-help text-sm mr-1 mb-0">Max File Size: 1MB</p>
                                                            <p class="text-help text-sm mb-0">Allowed File: .pdf, .csv, .doc, .docx, .jpeg, .jpg, .png</p>
                                                        </div>
                                                        <div class="file-preview box sm">
                                                            @if(!empty($product) && !empty($product->attachment))
                                                            <div class="d-flex justify-content-between align-items-center ml-1 file-preview-item"
                                                                 title="{{ $product->attachment->file_original_name }}">
                                                                <div class="align-items-center align-self-stretch d-flex justify-content-center thumb">
                                                                    <img src="{{ $product->attachment->image_path }}" class="img-fit">
                                                                </div>
                                                                <div class="col body">
                                                                    <h6 class="d-flex">
                                                                        <span class="text-truncate title">{{ $product->attachment->file_original_name }}</span>
                                                                        <span class="ext">{{ $product->attachment->extension }}</span>
                                                                    </h6>
                                                                    <p>{{ $product->attachment->file_size }} KB</p>
                                                                </div>
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div><!--end of row -->




                        </div>



                </div>
            </div>
        </section>
        <!-- users edit ends -->
    </div>

    <div class="content-body">
        <section class="users-edit">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <fieldset>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-primary" type="button"><i class="la la-search"></i></button>
                                        </div>

                                        <input type="text" class="form-control" placeholder="Button on both side" name="search">

                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">+</button>
                                        </div>

                                    </div>
                                </fieldset>
                                <ul id="search_show">

                                </ul>
                            </div>
                        </div>
                        {{-- search option end --}}

                        <div class="table-responsive my-2">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product Name</th>
                                        <th>Purchase Quantity</th>
                                        <th>Unit Cost (Before Discount)</th>
                                        <th>Discount Percent</th>
                                        <th>Unit Cost (Before Tax)</th>
                                        <th>Subtotal (Before Tax)</th>
                                        <th>Product Tax</th>
                                        <th>Net Cost</th>
                                        <th>Line Total</th>
                                        <th>Profit Margin %</th>
                                        <th>Unit Selling Price (Inc. tax)</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>Mark</td>
                                        <td>Otto</td>
                                        <td>@mdo</td>
                                        <td>Mark</td>
                                        <td>Otto</td>
                                        <td>@mdo</td>
                                        <td>Mark</td>
                                        <td>Otto</td>
                                        <td>@mdo</td>
                                        <td>Mark</td>
                                        <td>Otto</td>
                                        <td>@mdo</td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                        {{-- product show end --}}
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!--product show end -->

    <div class="content-body">
        <!-- users edit start -->
        <section class="users-edit">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <!-- users edit account form start -->

                        <div class="row">
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <div class="controls">
                                        <label>Discount Type: <b class="font-weight-bold text-warning"></b></label>
                                        <select class="select2 form-control" name="discrount_type" id="">
                                            <option value="None">None</option>
                                            <option value="Fixed">Fixed</option>
                                            <option value="Percentage">Percentage</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <div class="controls">
                                        <label>Discount Amount:</label>
                                        <input type="number" class="form-control" name="discrount_amount" value="0">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <div class="controls mt-3 float-right">
                                        <span>Discount:(-) $ 0.00</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <div class="controls">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>Purchase Tax: <b class="font-weight-bold text-warning"></b></label>
                                                <select name="discount_type" class="select2 form-control" id="">
                                                    <option value="None">None</option>
                                                    <option value="Fixed">Vat@10%</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <div class="controls">
                                        <div class="form-group">
                                            <div class="controls">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <div class="controls mt-3 float-right">
                                        <span>Purchase Tax:(+) $ 0.00</span>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="controls">
                                <label for="">Additional Notes:</label>
                                <textarea class="form-control" name="additional_note" id="" cols="10" rows="4"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- users edit ends -->
    </div>
    <div class="content-body">
        <section class="users-edit">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <div class="controls">
                                        <label>Shipping Details:</label>
                                        <input type="text" class="form-control" name="shipping_details" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <div class="controls">
                                        <label>(+) Additional Shipping charges:</label>
                                        <input type="number" class="form-control" name="shipping_charge" value="0">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <div class="controls text-center">
                                        <button id="additional" class="btn btn-primary">Add Additional Expenses</button>
                                    </div>
                                    <div style="display: none" class="row justify-content-center" id="additional_form">
                                        <div class="col-md-6 ">
                                            <table class="table table-bordered">
                                                <thead>
                                                  <tr>
                                                    <th scope="col">Additional expense name</th>
                                                    <th scope="col">Amount</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                  <tr>
                                                    <td>
                                                        <div class="">
                                                            <div class="controls ">
                                                                <input type="text" class="form-control" name="" id="">
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="">
                                                            <div class="controls ">
                                                                <input type="number" value="0" class="form-control" name="" id="">
                                                            </div>
                                                        </div>
                                                    </td>
                                                  </tr>
                                                  <tr>
                                                    <td>
                                                        <div class="">
                                                            <div class="controls ">
                                                                <input type="text" class="form-control" name="" id="">
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="">
                                                            <div class="controls ">
                                                                <input type="number" value="0" class="form-control" name="" id="">
                                                            </div>
                                                        </div>
                                                    </td>
                                                  </tr>
                                                  <tr>
                                                    <td>
                                                        <div class="">
                                                            <div class="controls ">
                                                                <input type="text" class="form-control" name="" id="">
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="">
                                                            <div class="controls ">
                                                                <input type="number" value="0" class="form-control" name="" id="">
                                                            </div>
                                                        </div>
                                                    </td>
                                                  </tr>
                                                  <tr>
                                                    <td>
                                                        <div class="">
                                                            <div class="controls ">
                                                                <input type="text" class="form-control" name="" id="">
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="">
                                                            <div class="controls ">
                                                                <input type="number" value="0" class="form-control" name="" id="">
                                                            </div>
                                                        </div>
                                                    </td>
                                                  </tr>
                                                  <tr>
                                                    <td>
                                                        <div class="">
                                                            <div class="controls ">
                                                                <input type="text" class="form-control" name="" id="">
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="">
                                                            <div class="controls ">
                                                                <input type="number" value="0" class="form-control" name="" id="">
                                                            </div>
                                                        </div>
                                                    </td>
                                                  </tr>

                                                </tbody>
                                              </table>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <div class="controls float-right">
                                        <span>Purchase Total: $ 0.00</span>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!--end shipping -->
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <div class="controls">
                                <label>Paid amount <b class="font-weight-bold text-warning">*</b></label>
                                <input type="text" class="form-control"
                                       name="paid_amount"
                                       value="{{ !empty($expense)? $expense->paid_amount: '0.00' }}"
                                       placeholder="Paid amount"
                                       step="0.01"
                                       data-fv-notempty='true'
                                       data-fv-blank='true'
                                       data-rule-required='true'
                                       data-fv-notempty-message='Paid amount Is Required'
                                       required
                                >
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label>Paid no <b class="font-weight-bold text-warning">*</b></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <span class="la la-calendar-o"></span>
                                    </span>
                                </div>
                                <input type='text' class="form-control pickadate datepicker" placeholder="select date"
                                       name="paid_on"
                                       value="{{ !empty($expense)? $expense->date: now()->format('m/d/Y') }}"
                                       data-fv-notempty='true'
                                       data-fv-blank='true'
                                       data-rule-required='true'
                                       data-fv-notempty-message='Paid on Is Required'
                                       required
                                />
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <div class="controls">
                                <label>Payment Method <b class="font-weight-bold text-warning">*</b></label>
                                <select class="select2 form-control" id="paymentMethodChange" name="payment_method"
                                        data-fv-notempty='true'
                                        data-fv-blank='true'
                                        data-rule-required='true'
                                        data-fv-notempty-message='Payment Method Is Required'
                                        required
                                >
                                    @if(!empty($paymentMethods) && count($paymentMethods) > 0)
                                        @foreach($paymentMethods as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <div class="controls">
                                <label>Payment Account <b class="font-weight-bold text-warning">*</b></label>
                                <select class="select2 form-control" name="account_id"
                                        data-fv-notempty='true'
                                        data-fv-blank='true'
                                        data-rule-required='true'
                                        data-fv-notempty-message='Payment Account Is Required'
                                        required
                                >
                                    <option value="0">None</option>
                                    @if(!empty($bankAccounts) && count($bankAccounts) > 0)
                                        @foreach($bankAccounts as $accountId => $accountInfo)
                                            <option value="{{ $accountId }}">{{ $accountInfo }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row" id="cardInfo" style="display: none">
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <div class="controls">
                                <label>Card Number</label>
                                <input type="hidden" name="payment_details[0][label]" value="Card Number">
                                <input type="text" class="form-control"
                                       name="payment_details[0][card_number]"
                                       placeholder="Card number"
                                >
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <div class="controls">
                                <label>Card holder name</label>
                                <input type="hidden" name="payment_details[1][label]" value="Card holder name">
                                <input type="text" class="form-control"
                                       name="payment_details[1][card_holder_name]"
                                       placeholder="Card holder name"
                                >
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <div class="controls">
                                <label>Card Transaction No.</label>
                                <input type="hidden" name="payment_details[2][label]" value="Transaction No.">
                                <input type="text" class="form-control"
                                       name="payment_details[2][card_transaction_no]"
                                       placeholder="Card Transaction no."
                                >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="chequeInfo" style="display: none">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <div class="controls">
                                <label>Cheque No</label>
                                <input type="hidden" name="payment_details[3][label]" value="Cheque No">
                                <input type="text" class="form-control"
                                       name="payment_details[3][cheque_no]"
                                       placeholder="Cheque No"
                                >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="bankInfo" style="display: none">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <div class="controls">
                                <label>Bank Account no</label>
                                <input type="hidden" name="payment_details[4][label]" value="Bank Account no">
                                <input type="text" class="form-control"
                                       name="payment_details[4][bank_account_no]"
                                       placeholder="Bank Account no"
                                >
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <div class="controls">
                                <label>Payment Note</label>
                                <textarea name="payment_note" rows="2" class="form-control" placeholder="Payment note..">{{ !empty($expense)? $expense->expense_note: '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-6 offset-md-6">
                        @include('layouts.includes.alert_messages')
                    </div>
                    <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1">
                        <button type="reset" class="btn btn-light mr-0 mr-sm-1">Cancel</button>
                        <button type="submit" class="btn btn-primary glow mb-1 mb-sm-0">Save
                            changes</button>
                    </div>
                </div>
                <!-- users edit account form ends -->
            </div>
        </div>
    </div>
</div>
@endsection

@section('pageJs')
<!-- BEGIN: Page Vendor JS-->
<script src="{{ asset('assets/vendors/js/pickers/pickadate/picker.js') }}"></script>
<script src="{{ asset('assets/vendors/js/pickers/pickadate/picker.date.js') }}"></script>
<!-- END: Page Vendor JS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>
<script>

$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $('select[name="supplier_id"]').on('change', function(){
               var supplier_id = $(this).val();
               if(supplier_id){
                $.ajax({
                    url:'/customer/information/'+supplier_id,
                    type:'GET',
                    dataType:"Json",
                    success:function(data){
                      $('#details').append('<h3>Billing Address:</h3> <span> '+ data.state +', '+ data.city +', '+ data.country +' </span> ')
                    }
                })
               }
        });


        // sarch

        $('input[name="search"]').on("keyup", function(){
               var search_key = $(this).val();

               if( search_key){
                $.ajax({
                    url:'/product/search/'+search_key,
                    type:'GET',
                    dataType:"Json",

                    success:function(data){
                    $('#search_show').html('')
                     data.forEach(element => {
                        $('#search_show').append('<li>'+ element.short_description +'</li>')
                     });
                    }
                })
               }
        });








    $(document).ready(function() {
        $('.birthdate-picker').pickadate({
            format: 'mmmm, d, yyyy'
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

    $(document).ready(function() {
        $('#additional').click(function(){
            $('#additional_form').toggle();
        })
    });


    // auto search
    var path = "{{ url('Product/search/query') }}";
    $('input.typeahead').typeahead({
        source: function (query, process) {
            return $.get(path, {query: query}, function (data) {
                alert(data)
                return process(data);
            });
        }
    });
</script>
@endsection
{{-- /*
* Author: Arup Kumer Bose
* Email: arupkumerbose@gmail.com
* Company Name: Brainchild Software <brainchildsoft@gmail.com>
*/ --}}
