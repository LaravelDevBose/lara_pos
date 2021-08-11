@extends('layouts.guest')

@section('pageTitle', 'Login')

@section('pageContent')
    <div class="content-body">
        <section class="row flexbox-container">
            <div class="col-12 d-flex align-items-center justify-content-center">
                <div class="col-lg-4 col-md-8 col-10 box-shadow-2 p-0">
                    <div class="card border-grey border-lighten-3 px-1 py-1 m-0">
                        <div class="card-header border-0">
                            <div class="card-title text-center">
                                <img class="mx-auto" src="{{ asset('logo.png') }}" alt="branding logo">
                            </div>
                            <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2"><span>Easily Growth Your Bussiness</span></h6>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form-horizontal GlobalFormValidation" method="POST" action="{{ route('login') }}">
                                    @csrf
                                    @include('layouts.includes.alert_messages')
                                    <fieldset class="form-group position-relative has-icon-left">
                                        <input type="text" class="form-control"
                                               name="user_name"
                                               id="user-name" placeholder="Your Username"
                                               data-fv-notempty='true'
                                               data-fv-blank='true'
                                               data-rule-required='true'
                                               data-fv-notempty-message='Username Is Required'
                                               >
                                        <div class="form-control-position">
                                            <i class="la la-user"></i>
                                        </div>
                                    </fieldset>
                                    <fieldset class="form-group position-relative has-icon-left">
                                        <input type="password" name="password" class="form-control"
                                               id="user-password" placeholder="Enter Password"
                                               data-fv-notempty='true'
                                               data-fv-blank='true'
                                               data-rule-required='true'
                                               data-fv-notempty-message='Password Is Required'
                                        >
                                        <div class="form-control-position">
                                            <i class="la la-key"></i>
                                        </div>
                                    </fieldset>
                                    <div class="form-group row">
                                        <div class="col-sm-6 col-12 text-center text-sm-left pr-0">
                                            <fieldset>
                                                <input type="checkbox" name="remember" id="remember-me" class="chk-remember">
                                                <label for="remember-me"> {{ __('Remember me') }}</label>
                                            </fieldset>
                                        </div>
                                        @if (Route::has('password.request'))
                                            <div class="col-sm-6 col-12 float-sm-left text-center text-sm-right">
                                                <a href="{{ route('password.request') }}" class="card-link">
                                                    {{ __('Forgot your password?') }}
                                                </a>
                                            </div>
                                        @endif

                                    </div>
                                    <button type="submit" class="btn btn-outline-info btn-block"><i class="ft-unlock"></i> {{ __('Log in') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
@endsection

@section('pageJs')
    <script>
        $('.chk-remember').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
        });
    </script>
@endsection
