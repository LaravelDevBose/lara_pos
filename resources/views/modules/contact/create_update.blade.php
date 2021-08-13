@extends('layouts.app')

@section('pageTitle', !empty($_GET['type'])? 'Add new '.ucfirst($_GET['type']): 'Add new contact')

@section('pageCss')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/pickers/pickadate/pickadate.css')}}">
@endsection

@section('pageContent')
    <div class="content-wrapper">
        <div class="content-header row">
            <?php
            if (!empty($_GET['type']) && $_GET['type'] == 'customer'){
                $breadcrumbs = [
                    'Customer list' => route('contacts.index', ['type'=>'customer']),
                    'Create Customer'=> !empty($contact)? 'Update new customer': 'Add new customer'
                ];
            }else{
                $breadcrumbs = [
                    'Supplier list' => route('contacts.index', ['type'=>'supplier']),
                    'Create Supplier' => !empty($contact)? 'Update new supplier':'Add new supplier'
                ];
            }

            ?>
            @include('layouts.includes.breadcrumb', $breadcrumbs)
        </div>
        <div class="content-body">
            <!-- users edit start -->
            <section class="users-edit">
                <div class="card">
                    <div class="card-content">
                        @if(!empty($contact))
                            <form class="form GlobalFormValidation" method="post" action="{{ route('contacts.update', $contact->contact_id) }}" >
                            @method('PUT')
                        @else
                            <form class="form GlobalFormValidation" method="post" action="{{ route('contacts.store') }}">
                        @endif
                        @csrf
                            <div class="card-body">
                                <input type="hidden" name="contact_type" value="{{ !empty($contact)? $contact->contact_type : ( !empty($_GET['type']) ? $_GET['type']: 'customer' ) }}">
                                <!-- users edit account form start -->
                                <div class="row">
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>{{ !empty($_GET['type']) ? ucfirst($_GET['type']). ' No.': 'Contact No' }} <b class="font-weight-bold text-warning">*</b></label>
                                                <input type="text" class="form-control"
                                                       name="unique_code"
                                                       value="{{ !empty($contact)? $contact->unique_code: $code }}"
                                                       placeholder="{{ !empty($_GET['type']) ? ucfirst($_GET['type']).' No': 'Contact No' }}"
                                                       data-fv-notempty='true'
                                                       data-fv-blank='true'
                                                       data-rule-required='true'
                                                       data-fv-notempty-message='{{ !empty($_GET['type']) ? ucfirst($_GET['type']).' No': 'Contact No' }} Is Required'
                                                >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>First Name <b class="font-weight-bold text-warning">*</b></label>
                                                <input type="text" class="form-control"
                                                       name="first_name"
                                                       value="{{ !empty($contact)? $contact->first_name: '' }}"
                                                       placeholder="First Name"
                                                       data-fv-notempty='true'
                                                       data-fv-blank='true'
                                                       data-rule-required='true'
                                                       data-fv-notempty-message='First Name Is Required'
                                                >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>Last Name</label>
                                                <input type="text" class="form-control"
                                                       name="last_name"
                                                       value="{{ !empty($contact)? $contact->last_name: '' }}"
                                                       placeholder="Last name"
                                                >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>Business Name</label>
                                                <input type="text" class="form-control"
                                                       name="business_name"
                                                       value="{{ !empty($contact)? $contact->business_name: '' }}"
                                                       placeholder="Business name"
                                                >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>Phone No. <b class="font-weight-bold text-warning">*</b></label>
                                                <input type="text" class="form-control"
                                                       name="mobile_no"
                                                       value="{{ !empty($contact)? $contact->mobile_no: '' }}"
                                                       placeholder="Phone no"
                                                       data-fv-notempty='true'
                                                       data-fv-blank='true'
                                                       data-rule-required='true'
                                                       data-fv-notempty-message='Phone no Is Required'
                                                       required
                                                >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>Alt. Phone no.</label>
                                                <input type="text" class="form-control"
                                                       name="alt_phone_no"
                                                       value="{{ !empty($contact)? $contact->alt_phone_no: '' }}"
                                                       placeholder="Alt. Phone no."
                                                >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>Email</label>
                                                <input type="email" class="form-control"
                                                       name="email"
                                                       value="{{ !empty($contact)? $contact->email: '' }}"
                                                       placeholder="Email address"
                                                >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <div class="controls position-relative">
                                                <label>Birth date</label>
                                                <input type="text" class="form-control birthdate-picker"
                                                       placeholder="Birth date"
                                                       value="{{ !empty($contact)? $contact->contact_dob: '' }}"
                                                >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>Opening Balance</label>
                                                <input type="number" step="0.01" class="form-control"
                                                       name="open_balance"
                                                       value="{{ !empty($contact)? $contact->open_balance: '0.00' }}"
                                                       placeholder="Opening Balance"
                                                >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>Credit Limit</label>
                                                <input type="number" step="0.01" class="form-control"
                                                       name="credit_limit"
                                                       value="{{ !empty($contact)? $contact->credit_limit: '' }}"
                                                       placeholder="Credit Limit"
                                                >
                                                <small class="text-help">Keep blank for no limit</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>Address</label>
                                                <input type="text" class="form-control"
                                                       name="address_line"
                                                       value="{{ !empty($contact)? $contact->address_line: '' }}"
                                                       placeholder="Address"
                                                >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-2">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>City</label>
                                                <input type="text" class="form-control"
                                                       name="city"
                                                       value="{{ !empty($contact)? $contact->city: '' }}"
                                                       placeholder="City"
                                                >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-2">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>State</label>
                                                <input type="text" class="form-control"
                                                       name="state"
                                                       value="{{ !empty($contact)? $contact->state: '' }}"
                                                       placeholder="State"
                                                >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-2">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>Zip code</label>
                                                <input type="text" class="form-control"
                                                       name="zip_code"
                                                       value="{{ !empty($contact)? $contact->zip_code: '' }}"
                                                       placeholder="Zip code"
                                                >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-2">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label>Country</label>
                                                <input type="text" class="form-control"
                                                       name="country"
                                                       value="{{ !empty($contact)? $contact->country: '' }}"
                                                       placeholder="Country "
                                                >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-2">
                                        <div class="form-group">
                                            <label>Contact Status <b class="font-weight-bold text-warning">*</b></label>
                                            <div class="input-group">
                                                <div class="d-inline-block custom-control custom-radio mr-1">
                                                    <input type="radio" name="status"
                                                           value="{{ config('constant.active') }}"
                                                           class="custom-control-input" id="yes1"
                                                        {{ empty($contact) || $contact->status == 1 ? 'checked': '' }}
                                                    >
                                                    <label class="custom-control-label" for="yes1">Active</label>
                                                </div>
                                                <div class="d-inline-block custom-control custom-radio">
                                                    <input type="radio" name="status"
                                                           value="{{ config('constant.inactive') }}"
                                                           class="custom-control-input" id="no1"
                                                        {{ !empty($contact) && $contact->status == 2 ? 'checked': '' }}
                                                    >
                                                    <label class="custom-control-label" for="no1">Inactive</label>
                                                </div>
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
    <script src="{{ asset('assets/vendors/js/pickers/pickadate/picker.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/pickers/pickadate/picker.date.js') }}"></script>
    <!-- END: Page Vendor JS-->
    <script>
        $(document).ready(function () {
            $('.birthdate-picker').pickadate({
                format: 'mmmm, d, yyyy'
            });
        });

    </script>

@endsection
{{-- /*
* Author: Arup Kumer Bose
* Email: arupkumerbose@gmail.com
* Company Name: Brainchild Software <brainchildsoft@gmail.com>
*/ --}}
