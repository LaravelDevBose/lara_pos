@extends('layouts.app')

@section('pageTitle', !empty($expense)? 'Update Expense':'Add new Expense')

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
                'Expense List' => route('expenses.index'),
                'Business Create' => !empty($expense)? 'Update Expense':'Add new Expense'
            ];

            ?>
            @include('layouts.includes.breadcrumb', $breadcrumbs)
        </div>
        <div class="content-body">
            @if(!empty($expense))
                <form class="form GlobalFormValidation" method="post" action="{{ route('expenses.update', $expense->expense_id) }}" >
                @method('PUT')
            @else
                <form class="form GlobalFormValidation" method="post" action="{{ route('expenses.store') }}">
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
                                                <label>Business Location <b class="font-weight-bold text-warning">*</b></label>
                                                <select class="select2 form-control" name="location_id"
                                                        data-fv-notempty='true'
                                                        data-fv-blank='true'
                                                        data-rule-required='true'
                                                        data-fv-notempty-message='Business Location Is Required'
                                                        required
                                                >
                                                    <option value=" ">Select a Business Location</option>
                                                    @if(!empty($locations) && count($locations) > 0)
                                                        @foreach($locations as $locationId=> $storeName)
                                                            <option value="{{ $locationId }}">{{ $storeName }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>Reference No <b class="font-weight-bold text-warning">*</b></label>
                                                <input type="text" class="form-control"
                                                       name="reference_no"
                                                       value="{{ !empty($expense)? $expense->reference_no: $code }}"
                                                       placeholder="Reference No"
                                                       data-fv-notempty='true'
                                                       data-fv-blank='true'
                                                       data-rule-required='true'
                                                       data-fv-notempty-message='Reference No Is Required'
                                                       required
                                                >
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
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>Expense Head <b class="font-weight-bold text-warning">*</b></label>
                                                <select class="select2 form-control" name="head_id"
                                                        data-fv-notempty='true'
                                                        data-fv-blank='true'
                                                        data-rule-required='true'
                                                        data-fv-notempty-message='Expense Head Is Required'
                                                        required
                                                >
                                                    <option value=" ">Select a Expense Head</option>
                                                    @if(!empty($heads) && count($heads) > 0)
                                                        @foreach($heads as $headId => $headTitle)
                                                            <option value="{{ $headId }}">{{ $headTitle }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
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
                                                       value="{{ !empty($expense)? $expense->total_amount: '' }}"
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
                                                <textarea name="expense_note" rows="2" class="form-control" placeholder="Expense note..">{{ !empty($expense)? $expense->expense_note: '' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
