@extends('layouts.app')

@section('pageTitle', 'New Purchase')

@section('pageCss')
<link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/pickers/pickadate/pickadate.css')}}">
<style>
    .table.table-sm th {
        padding: 10px 5px;
        border: 1px solid #e3ebf3;
        vertical-align: bottom;
        word-wrap: break-word;
        line-height: 1.42857143;
        white-space: normal;
    }
    .table.table-sm td{
        padding: 5px;
        vertical-align: top!important;
        word-wrap: break-word;
        line-height: 1.42857143;
        white-space: normal;
    }
    .table-responsive{
        min-height: .01%;
        overflow-x: auto;
    }
</style>
@endsection

@section('pageContent')
<div class="content-wrapper">
    <div class="content-header row">
        <?php
            $breadcrumbs = [
                'Purchase List' => route('purchases.index'),
                'Purchase Create' => 'Add new purchase'
            ];

        ?>
        @include('layouts.includes.breadcrumb', $breadcrumbs)
    </div>

    <div id="test">
        <p></p>
    </div>
    <div class="content-body">
        <form action="" class="GlobalFormValidation">
            <div class="row">
                <div class="col-sm-12 col-md-4">
                    <div class="form-group">
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
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <!-- users edit account form start -->
                                <div class="row">
                                    <div class="col-sm-12 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>Supplier: <b class="font-weight-bold text-warning">*</b></label>
                                                <select class="select2 form-control" name="contact_id" id="contact_id">
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
                                            <div class="col-sm-12 col-md-4">
                                                <div class="form-group">
                                                    <div class="controls">
                                                        <label>Reference No:</label>
                                                        <input type="text" class="form-control" placeholder="Reference No" name="reference_no" value="">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 col-md-4">
                                                <div class="form-group">
                                                    <label>Date <b class="font-weight-bold text-warning">*</b></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <span class="la la-calendar-o"></span>
                                                            </span>
                                                        </div>
                                                        <input type='text' class="form-control pickadate datepicker" placeholder="select date"
                                                               value="{{ now()->format('m/d/Y') }}"
                                                               name="expense_date"
                                                               data-fv-notempty='true'
                                                               data-fv-blank='true'
                                                               data-rule-required='true'
                                                               data-fv-notempty-message='Purchase Date Is Required'
                                                               required
                                                        />
                                                    </div>
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
                                                                        <input type="file" name="image_path" class="custom-file-input file-input"
                                                                               id="attachment"
                                                                               accept="application/pdf,text/csv,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,image/jpeg,image/jpg,image/png"
                                                                        >
                                                                        <label class="custom-file-label" for="attachment" aria-describedby="inputGroupFile02">Choose file</label>
                                                                    </div>
                                                                </div>
                                                                <p class="text-help text-sm mr-1 mb-0">Max File Size: 1MB</p>
                                                                <p class="text-help text-sm mb-0">Allowed File: .pdf, .csv, .doc, .docx, .jpeg, .jpg, .png</p>
                                                            </div>
                                                            <div class="file-preview box sm">
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
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
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
                                                <select class="form-control BCS-product-data-ajax" id="select2-ajax"
                                                        data-purchase_entry_url="{{ route('ajax.get.purchase_entry') }}"
                                                ></select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- search option end --}}
                                <div class="row my-2">
                                    <div class="col-md-12 border-bottom">
                                        <div class="table-responsive mb-2">
                                            <table class="table table-striped table-sm table-bordered text-center" id="BCS_purchase_entry_table">
                                                <thead class="bg-primary text-white">
                                                <tr class="">
                                                    <th >Product Details</th>
                                                    <th >Purchase Quantity</th>
                                                    <th >Unit Cost
                                                        <p class="m-0"><small>(Before Dis)</small></p>
                                                    </th>
                                                    <th >Discount Percent</th>
                                                    <th >Unit Cost
                                                        <p class="m-0"><small>(Before Tax)</small></p>
                                                    </th>
                                                    <th >Subtotal
                                                        <p class="m-0"><small>(Before Tax)</small></p>
                                                    </th>
                                                    <th >Product Tax</th>
                                                    <th >Net Cost</th>
                                                    <th >Line Total</th>
                                                    <th >Profit Margin
                                                        <p class="m-0"><small>(%)</small></p>
                                                    </th>
                                                    <th >Unit Selling Price
                                                        <p class="m-0"><small>(Inc. tax)</small></p>
                                                    </th>
                                                    <th >Action</th>
                                                </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>

                                        </div>
                                    </div>
                                    <div class="col-md-5 offset-7">
                                        <table class="table table-borderless mt-2 table-md">
                                            <tbody>
                                            <tr style="border: 0">
                                                <th class="col-7 text-right">Total Item: </th>
                                                <th class="col-3 text-right pl-3"><span id="BCS_total_item">3.00</span></th>
                                            </tr>
                                            <tr style="border: 0">
                                                <th class="col-7 text-right">Net Total Amount: </th>
                                                <th class="col-3 text-right pl-3"><span id="BCS_total_amount">$5354.25</span></th>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <input type="hidden" id="total_row" value="0">
                                    </div>
                                </div>
                                {{-- product show end --}}
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
                                                <input id="discount_amount_value" type="number" class="form-control" name="discount_amount">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <div class="controls mt-3 float-right">
                                                <span id="discount_amount_show">Discount:(-) $ 0.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
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

                                    <div class="col-sm-12 col-md-4 offset-md-4">
                                        <div class="form-group">
                                            <div class="controls mt-3 float-right">
                                                <span>Purchase Tax:(+) $ 0.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label for="">Additional Notes:</label>
                                                <textarea class="form-control" name="additional_note" id="" rows="2"></textarea>
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
                                    <div class="col-sm-12 col-md-5 col-lg-5">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>Shipping Details:</label>
                                                <input type="text" class="form-control" name="shipping_details" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3 col-lg-3 offset-md-3">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>(+) Additional Shipping charges:</label>
                                                <input type="number" class="form-control" name="shipping_charge" value="0">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-2 offset-md-5">
                                        <button type="button" onclick="$('#additional_form').toggle();" class="btn btn-primary mb-2">Add Additional Expenses</button>
                                    </div>
                                    <div class="col-sm-12 col-md-6 offset-md-3">
                                        <div style="display: none" class="justify-content-center" id="additional_form">
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
                                                </tbody>
                                            </table>
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
                                    <div class="col-sm-12 col-md-6">
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
        </form>
    </div>
    <!--end shipping -->

</div>
@endsection

@section('pageJs')
<!-- BEGIN: Page Vendor JS-->
<script src="{{ asset('assets/vendors/js/pickers/pickadate/picker.js') }}"></script>
<script src="{{ asset('assets/vendors/js/pickers/pickadate/picker.date.js') }}"></script>
<script src="{{ asset('bcs-assets/js/purchase.js') }}"></script>
<!-- END: Page Vendor JS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>
<script>
    let sum = 0;
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
                    $('#details').append('<div> <h4>Supplier Self info.</h4> <div class="ml-2"> <p><span>'+ data.first_name+'</span> <span>'+ data.last_name+'</span> <span>('+data.mobile_no+')</span> <br><span>'+data.email+'</span> </p></div> <div><h4>Supplier Location</h4> <div class="ml-2"><p> <sapn>'+data.state+'</sapn>, <span>'+data.city+'</span>, <span>'+data.country+'</span>.</p></div> </div> </div>')                }
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
