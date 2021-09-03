@extends('layouts.app')

@section('pageTitle', 'Add New Sell')

@section('pageCss')
<link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/pickers/pickadate/pickadate.css')}}">
<style>
    .select2.select2-container{
        width: 90%!important;
    }
</style>
@endsection

@section('pageContent')
<div class="content-wrapper">
    <div class="content-header row">
        <?php
        $breadcrumbs = [
            'sell List' => route('sells.index'),
            'Purchese Create' => 'Add new Sells'
        ];
        ?>
        @include('layouts.includes.breadcrumb', $breadcrumbs)
    </div>

    <!--start here sell-->
    <div class="content-body">
        <div class="row">
            <div class="col-sm-12 col-md-4">
                <div class="form-group">
                    <label>Business Location:* <b class="font-weight-bold text-warning">*</b></label>
                    <select class="select2 form-control " name="businessLocation_id" id="" style="width: 90%">
                        @foreach ($businessLocations as $item)
                            <option value="">Please Select</option>
                            <option value="{{ $item->id }}"> {{ $item->store_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <!-- users edit account form start -->
                            <div class="row">
                                <div class="col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <label>Customers:<b class="font-weight-bold text-warning">*</b></label>
                                        <div class="input-group">
                                            <select class="select2 form-control " name="contact_id" id="contact_id">
                                                @foreach ($customers as $item)
                                                    <option value="">Please Select</option>
                                                    <option value="{{ $item->contact_id }}"> {{ $item->first_name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="button">+</button>
                                            </div>
                                        </div>
                                    </div>
                                    <p id="details">
                                    </p>
                                </div>
                                <div class="col-sm-12 col-md-8">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group">
                                                <div class="controls">
                                                    <label>Invoice No.:</label>
                                                    <input type="text" class="form-control" name="reference_no" value="">
                                                    <p>Keep blank to auto generate</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group">
                                                <label>Sale Date: <b class="font-weight-bold text-warning">*</b></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <span class="la la-calendar-o"></span>
                                                            </span>
                                                        </div>
                                                    <input type='text' class="form-control pickadate datepicker"
                                                           placeholder="select date" name="paid_on"
                                                           value="{{ now()->format('m/d/Y') }}"
                                                           data-fv-notempty='true'
                                                           data-fv-blank='true'
                                                           data-rule-required='true'
                                                           data-fv-notempty-message='Sell Date Is Required'
                                                           required
                                                    />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group">
                                                <label>Status: <b class="font-weight-bold text-warning">*</b></label>
                                                <select class="select2 form-control " name="businessLocation_id" id="">
                                                    <option value="">Please Select</option>
                                                    <option value="">Final</option>
                                                    <option value="">Draft</option>
                                                    <option value="">Quotation </option>
                                                    <option value="">Proforma </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                            <label for="">Pay term:</label>
                                            <div class="input-group form-group">
                                                <input type="text" class="form-control" placeholder="pay term" value="15">
                                                <div class="input-group-append">
                                                    <select name="" id="" class="form-control">
                                                        <option value="Days">Days</option>
                                                        <option value="Months">Months</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <div class="controls">
                                                    <label for="attachment">Attach Document:</label>
                                                    <div class="flex">
                                                        <div class="input-group">
                                                            <div style="width: 100%;">
                                                                <div class="custom-file">
                                                                    <input type="file" name="image_path" class="custom-file-input file-input" id="attachment"
                                                                           accept="application/pdf,text/csv,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,image/jpeg,image/jpg,image/png"
                                                                    >
                                                                    <label class="custom-file-label" for="attachment" aria-describedby="inputGroupFile02">Choose file</label>
                                                                </div>
                                                            </div>
                                                            <p class="text-help text-sm mr-1 mb-0">Max File Size: 1MB</p>
                                                            <p class="text-help text-sm mb-0">Allowed File: .pdf, .csv, .doc, .docx, .jpeg, .jpg, .png</p>
                                                        </div>
                                                        <div class="file-preview box sm"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <button class="btn btn-primary" type="button"><i class="la la-search"></i></button>
                                            </div>
                                            <select class="form-control BCS-product-data-ajax BCS-product-sell" id="select2-ajax"></select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="my-3">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col">Product</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Unit Price</th>
                                        <th scope="col">Discount</th>
                                        <th scope="col">Tax</th>
                                        <th scope="col">Price inc. tax</th>
                                        <th scope="col">Subtotal</th>
                                        <th scope="col">X</th>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody id="product_show">
                                    </tbody>
                                </table>
                                <div class="float-right">
                                    <p>
                                        <span>Items: 0.00</span>
                                        <span> Total: 0.00 </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
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
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <div class="controls">
                                            <div class="form-group">
                                                <div class="controls">
                                                    <label>Shipping Details:<b class="font-weight-bold text-warning">*</b></label>
                                                    <textarea placeholder="Shipping Details" class="form-control" name="" id="" cols="10" rows="4"></textarea>
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
                                                    <label>Shipping Address:<b class="font-weight-bold text-warning">*</b></label>
                                                    <textarea placeholder="Shipping Address" class="form-control" name="" id="" cols="10" rows="4"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <div class="controls">
                                            <label>Shipping Charges.:</label>
                                            <input type="number" class="form-control" name="reference_no" value="0.00">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <div class="controls">
                                            <div class="form-group">
                                                <div class="controls">
                                                    <label>Status: <b class="font-weight-bold text-warning">*</b></label>
                                                    <select class="select2 form-control " name="businessLocation_id" id="">
                                                        <option value="">Please Select</option>
                                                        <option value="">Final</option>
                                                        <option value="">Draft</option>
                                                        <option value="">Quotation </option>
                                                        <option value="">Proforma </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <div class="controls">
                                            <label>Delivered To:</label>
                                            <input type="test" class="form-control" name="" placeholder="Delivered To" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <div class="controls">
                                            <label for="attachment">Attach Document: @if(!empty($product) &&
                                            !empty($product->attachment)) @else <b class="font-weight-bold text-warning">*</b>@endif</label>
                                            <div class="flex">
                                                <div class="input-group">
                                                    <div style="width: 100%;">
                                                        <div class="custom-file">
                                                            <input type="file" name="image_path" class="custom-file-input file-input" id="attachment" accept="application/pdf,text/csv,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,image/jpeg,image/jpg,image/png" @if(empty($product) || empty($product->attachment))
                                                            data-fv-notempty='true'
                                                                   data-fv-blank='true'
                                                                   data-rule-required='true'
                                                                   data-fv-notempty-message='Attach Document Is Required'
                                                                   required
                                                                @endif
                                                            >
                                                            <label class="custom-file-label" for="attachment" aria-describedby="inputGroupFile02">Choose
                                                                file</label>
                                                        </div>
                                                    </div>
                                                    <p class="text-help text-sm mr-1 mb-0">Max File Size: 1MB</p>
                                                    <p class="text-help text-sm mb-0">Allowed File: .pdf, .csv,
                                                        .doc, .docx, .jpeg, .jpg, .png</p>
                                                </div>
                                                <div class="file-preview box sm">
                                                    @if(!empty($product) && !empty($product->attachment))
                                                        <div class="d-flex justify-content-between align-items-center ml-1 file-preview-item" title="{{ $product->attachment->file_original_name }}">
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
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <div class="controls">
                                            <label>Paid amount <b class="font-weight-bold text-warning">*</b></label>
                                            <input type="text" class="form-control" name="paid_amount" value="{{ !empty($expense)? $expense->paid_amount: '0.00' }}" placeholder="Paid amount" step="0.01" data-fv-notempty='true' data-fv-blank='true' data-rule-required='true' data-fv-notempty-message='Paid amount Is Required' required>
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
                                            <input type='text' class="form-control pickadate datepicker" placeholder="select date" name="paid_on" value="{{ !empty($expense)? $expense->date: now()->format('m/d/Y') }}" data-fv-notempty='true' data-fv-blank='true' data-rule-required='true' data-fv-notempty-message='Paid on Is Required' required />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <div class="controls">
                                            <label>Payment Method <b class="font-weight-bold text-warning">*</b></label>
                                            <select class="select2 form-control" id="paymentMethodChange" name="payment_method" data-fv-notempty='true' data-fv-blank='true' data-rule-required='true' data-fv-notempty-message='Payment Method Is Required' required>
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
                                            <select class="select2 form-control" name="account_id" data-fv-notempty='true' data-fv-blank='true' data-rule-required='true' data-fv-notempty-message='Payment Account Is Required' required>
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
                                            <input type="text" class="form-control" name="payment_details[0][card_number]" placeholder="Card number">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <div class="controls">
                                            <label>Card holder name</label>
                                            <input type="hidden" name="payment_details[1][label]" value="Card holder name">
                                            <input type="text" class="form-control" name="payment_details[1][card_holder_name]" placeholder="Card holder name">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <div class="controls">
                                            <label>Card Transaction No.</label>
                                            <input type="hidden" name="payment_details[2][label]" value="Transaction No.">
                                            <input type="text" class="form-control" name="payment_details[2][card_transaction_no]" placeholder="Card Transaction no.">
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
                                            <input type="text" class="form-control" name="payment_details[3][cheque_no]" placeholder="Cheque No">
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
                                            <input type="text" class="form-control" name="payment_details[4][bank_account_no]" placeholder="Bank Account no">
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
        </div>
        <!-- users edit ends -->
    </div>
</div>
@endsection

@section('pageJs')
<script src="{{ asset('assets/vendors/js/pickers/pickadate/picker.js') }}"></script>
<script src="{{ asset('assets/vendors/js/pickers/pickadate/picker.date.js') }}"></script>

<script>
    $(document).ready(function() {
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

        $('.BCS-product-data-ajax').on('select2:select', function (e) {
            var data = e.params.data;
                $('#product_show').append(' <tr> <td>'+ data.product_name +'</td>    <td>1</td>   <td> 0 </td> <td> 0 </td> <td> 0 </td>  <td>0</td>  <td>0</td>   <td> <a class="btn btn-sm btn-danger" href="">X</a> </td>  </tr>')
                    $(this).val(null).trigger('change');
        });
    });

    //supplier and customer information show for purchase and sell page
    $('select[name="contact_id"]').on('change', function(){
        var contact_id = $(this).val()
        if(contact_id){
            $.ajax({
                url:'/contact/details/'+contact_id,
                type:'GET',
                dataType:'json',
                success:function(data){
                    $('#details').append('<p> <h4>Information</h4> <br> '+ data.city +' </p>')
                }
            })
        }
    })
</script>
@endsection
{{-- /*
* Author: Arup Kumer Bose
* Email: arupkumerbose@gmail.com
* Company Name: Brainchild Software <brainchildsoft@gmail.com>
*/ --}}
