@extends('layouts.app')

@section('pageTitle', !empty($account)? 'Update Account': 'Add new Account')

@section('pageCss')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/forms/selects/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/forms/selects/select2.min.css')}}">
@endsection

@section('pageContent')
    <div class="content-wrapper">
        <div class="content-header row">
            <?php
                $breadcrumbs = [
                    'Account list' => route('bank_accounts.index'),
                    'Create Account' => !empty($account)? 'Update account':'Add new account'
                ];
            ?>
            @include('layouts.includes.breadcrumb', $breadcrumbs)
        </div>
        <div class="content-body">
            <!-- users edit start -->
            <section class="users-edit">
                <div class="card">
                    <div class="card-content">
                        @if(!empty($account))
                            <form class="form GlobalFormValidation" method="post" action="{{ route('bank_accounts.update', $account->bank_acc_id) }}" >
                            @method('PUT')
                        @else
                            <form class="form GlobalFormValidation" method="post" action="{{ route('bank_accounts.store') }}">
                        @endif
                        @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12 col-md-5">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>Account Name <b class="font-weight-bold text-warning">*</b></label>
                                                <input type="text" class="form-control"
                                                       name="account_name"
                                                       value="{{ !empty($account)? $account->account_name: '' }}"
                                                       placeholder="Account Name"
                                                       data-fv-notempty='true'
                                                       data-fv-blank='true'
                                                       data-rule-required='true'
                                                       data-fv-notempty-message='Account Name Is Required'
                                                       required
                                                >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>Account Holder Name</label>
                                                <input type="text" class="form-control"
                                                       name="acc_holder_name"
                                                       value="{{ !empty($account)? $account->acc_holder_name: '' }}"
                                                       placeholder="Full Name"
                                                >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>Account Number <b class="font-weight-bold text-warning">*</b></label>
                                                <input type="text" class="form-control"
                                                       name="account_number"
                                                       value="{{ !empty($account)? $account->account_number: '' }}"
                                                       placeholder="Account Number"
                                                       data-fv-notempty='true'
                                                       data-fv-blank='true'
                                                       data-rule-required='true'
                                                       data-fv-notempty-message='Account Number Is Required'
                                                       required
                                                >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="controls">
                                                <label for="account_type">Account Type <b class="font-weight-bold text-warning">*</b></label>
                                                <select name="account_type" id="account_type" class="form-control"
                                                        data-fv-notempty='true'
                                                        data-fv-blank='true'
                                                        data-rule-required='true'
                                                        data-fv-notempty-message='Account Type Is Required'
                                                        required
                                                >
                                                    @foreach($accountTypes as $key=> $value)
                                                        <option value="{{ $key }}" {{ !empty($account) && $account->account_type == $key? 'selected': '' }}>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>Opening Balance <b class="font-weight-bold text-warning">*</b></label>
                                                <input type="number" step="0.01" class="form-control"
                                                       name="opening_balance"
                                                       value="{{ !empty($account)? $account->opening_balance: '0.00' }}"
                                                       placeholder="Opening Balance"
                                                       data-fv-notempty='true'
                                                       data-fv-blank='true'
                                                       data-rule-required='true'
                                                       data-fv-notempty-message='Opening Balance Is Required'
                                                       required
                                                >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Account Status <b class="font-weight-bold text-warning">*</b></label>
                                            <div class="input-group">
                                                <div class="d-inline-block custom-control custom-radio mr-1">
                                                    <input type="radio" name="status"
                                                           value="{{ config('constant.active') }}"
                                                           class="custom-control-input" id="yes1"
                                                        {{ empty($account) || $account->status == 1 ? 'checked': '' }}
                                                    >
                                                    <label class="custom-control-label" for="yes1">Active</label>
                                                </div>
                                                <div class="d-inline-block custom-control custom-radio">
                                                    <input type="radio" name="status"
                                                           value="{{ config('constant.inactive') }}"
                                                           class="custom-control-input" id="no1"
                                                        {{ !empty($account) && $account->status == 2 ? 'checked': '' }}
                                                    >
                                                    <label class="custom-control-label" for="no1">Inactive</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-7">
                                        <label>Account details</label>
                                        <table class="table table-striped table-borderless table-sm">
                                            <thead>
                                            <tr class="bg-gray-50">
                                                <th>Label</th>
                                                <th>Value</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <div class="form-group mb-0">
                                                        <input type="text" class="form-control"
                                                               name="account_details[0][label]"
                                                               value="{{ !empty($account)? $account->account_details[0]['label']: '' }}"
                                                               placeholder="Label"
                                                        >
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group mb-0">
                                                        <input type="text" class="form-control"
                                                               name="account_details[0][value]"
                                                               value="{{ !empty($account)? $account->account_details[0]['value']: '' }}"
                                                               placeholder="Value"
                                                        >
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="form-group mb-0">
                                                        <input type="text" class="form-control"
                                                               name="account_details[1][label]"
                                                               value="{{ !empty($account)? $account->account_details[1]['label']: '' }}"
                                                               placeholder="Label"
                                                        >
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group mb-0">
                                                        <input type="text" class="form-control"
                                                               name="account_details[1][value]"
                                                               value="{{ !empty($account)? $account->account_details[1]['value']: '' }}"
                                                               placeholder="Value"
                                                        >
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="form-group mb-0">
                                                        <input type="text" class="form-control"
                                                               name="account_details[2][label]"
                                                               value="{{ !empty($account)? $account->account_details[2]['label']: '' }}"
                                                               placeholder="Label"
                                                        >
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group mb-0">
                                                        <input type="text" class="form-control"
                                                               name="account_details[2][value]"
                                                               value="{{ !empty($account)? $account->account_details[2]['value']: '' }}"
                                                               placeholder="Value"
                                                        >
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="form-group mb-0">
                                                        <input type="text" class="form-control"
                                                               name="account_details[3][label]"
                                                               value="{{ !empty($account)? $account->account_details[3]['label']: '' }}"
                                                               placeholder="Label"
                                                        >
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group mb-0">
                                                        <input type="text" class="form-control"
                                                               name="account_details[3][value]"
                                                               value="{{ !empty($account)? $account->account_details[3]['value']: '' }}"
                                                               placeholder="Value"
                                                        >
                                                    </div>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <div class="form-group">
                                            <label for="account_note">Note</label>
                                            <textarea name="account_note" id="account_note" rows="2" class="form-control" placeholder="Note..">
                                                {{ !empty($account)? $account->account_note: '' }}
                                            </textarea>
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
                        </form>
                    </div>
                </div>
            </section>
            <!-- users edit ends -->
        </div>
    </div>
@endsection

@section('pageJs')
    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
    <!-- END: Page Vendor JS-->
@endsection
{{-- /*
* Author: Arup Kumer Bose
* Email: arupkumerbose@gmail.com
* Company Name: Brainchild Software <brainchildsoft@gmail.com>
*/ --}}
