@extends('layouts.app')

@section('pageTitle', !empty($location)? 'Update business location':'Add new business location')

@section('pageCss')

@endsection

@section('pageContent')
    <div class="content-wrapper">
        <div class="content-header row">
            <?php
            $breadcrumbs = [
                'Business Locations' => route('business_locations.index'),
                'Business Create' => !empty($location)? 'Update business location':'Add new business location'
            ];

            ?>
            @include('layouts.includes.breadcrumb', $breadcrumbs)
        </div>
        <div class="content-body">
            <!-- users edit start -->
            <section class="users-edit">
                <div class="card">
                    <div class="card-content">
                        @if(!empty($location))
                            <form class="form GlobalFormValidation" method="post" action="{{ route('business_locations.update', $location->location_id) }}" >
                            @method('PUT')
                        @else
                            <form class="form GlobalFormValidation" method="post" action="{{ route('business_locations.store') }}">
                        @endif
                        @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12 col-md-10 offset-md-1">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-4">
                                                <div class="form-group">
                                                    <div class="controls">
                                                        <label>Business Name</label>
                                                        <input type="text" class="form-control"
                                                               name="store_name"
                                                               value="{{ !empty($location)? $location->store_name: '' }}"
                                                               placeholder="Business name"
                                                               data-fv-notempty='true'
                                                               data-fv-blank='true'
                                                               data-rule-required='true'
                                                               data-fv-notempty-message='Business name Is Required'
                                                               required
                                                        >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-4">
                                                <div class="form-group">
                                                    <div class="controls">
                                                        <label>Phone No. <b class="font-weight-bold text-warning">*</b></label>
                                                        <input type="text" class="form-control"
                                                               name="phone_no"
                                                               value="{{ !empty($location)? $location->phone_no: '' }}"
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
                                                               value="{{ !empty($location)? $location->alt_phone_no: '' }}"
                                                               placeholder="Alt. Phone no."
                                                        >
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 col-md-4">
                                                <div class="form-group">
                                                    <div class="controls">
                                                        <label>Landmark</label>
                                                        <input type="text" class="form-control"
                                                               name="landmark"
                                                               value="{{ !empty($location)? $location->landmark: '' }}"
                                                               placeholder="landmark"
                                                        >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-4">
                                                <div class="form-group">
                                                    <div class="controls">
                                                        <label>City</label>
                                                        <input type="text" class="form-control"
                                                               name="city"
                                                               value="{{ !empty($location)? $location->city: '' }}"
                                                               placeholder="City"
                                                        >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-4">
                                                <div class="form-group">
                                                    <div class="controls">
                                                        <label>State</label>
                                                        <input type="text" class="form-control"
                                                               name="state"
                                                               value="{{ !empty($location)? $location->state: '' }}"
                                                               placeholder="State"
                                                        >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-4">
                                                <div class="form-group">
                                                    <div class="controls">
                                                        <label>Zip code</label>
                                                        <input type="text" class="form-control"
                                                               name="zip_code"
                                                               value="{{ !empty($location)? $location->zip_code: '' }}"
                                                               placeholder="Zip code"
                                                        >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-4">
                                                <div class="form-group">
                                                    <div class="controls">
                                                        <label>Country</label>
                                                        <input type="text" class="form-control"
                                                               name="country"
                                                               value="{{ !empty($location)? $location->country: '' }}"
                                                               placeholder="Country "
                                                        >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-4">
                                                <div class="form-group">
                                                    <label>Location Status <b class="font-weight-bold text-warning">*</b></label>
                                                    <div class="input-group">
                                                        <div class="d-inline-block custom-control custom-radio mr-1">
                                                            <input type="radio" name="status"
                                                                   value="{{ config('constant.active') }}"
                                                                   class="custom-control-input" id="yes1"
                                                                {{ empty($location) || $location->status == 1 ? 'checked': '' }}
                                                            >
                                                            <label class="custom-control-label" for="yes1">Active</label>
                                                        </div>
                                                        <div class="d-inline-block custom-control custom-radio">
                                                            <input type="radio" name="status"
                                                                   value="{{ config('constant.inactive') }}"
                                                                   class="custom-control-input" id="no1"
                                                                {{ !empty($location) && $location->status == 2 ? 'checked': '' }}
                                                            >
                                                            <label class="custom-control-label" for="no1">Inactive</label>
                                                        </div>
                                                    </div>
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

@endsection
{{-- /*
* Author: Arup Kumer Bose
* Email: arupkumerbose@gmail.com
* Company Name: Brainchild Software <brainchildsoft@gmail.com>
*/ --}}
