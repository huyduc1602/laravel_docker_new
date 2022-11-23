@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => '', 'title' => __('Material Dashboard')])

@section('content')
    <div class="container position-absolute top-50 start-50 translate-middle" style="height: auto;">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-4 col-md-6 col-sm-8 ml-auto mr-auto">
                @if (session('status'))
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="alert alert-success">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <i class="material-icons">close</i>
                                </button>
                                <span>{{ session('status') }}</span>
                            </div>
                        </div>
                    </div>
                @endif
                <form class="form" method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <div class="card card-login card-hidden mb-3">
                        <div class="card-header card-header-primary text-center">
                            <h4 class="card-title"><strong>{{ __('Reset Password') }}</strong></h4>
                        </div>
                        <div class="card-body ">
                            <div class="bmd-form-group{{ $errors->has('email') ? ' has-danger' : '' }} mt-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="material-icons">email</i>
                                        </span>
                                    </div>
                                    <input type="hidden" name="email" class="form-control" value="{{ $user->email }}">
                                    <input type="email" name="email" class="form-control" value="{{ $user->email }}"
                                        disabled>
                                </div>
                                @if ($errors->has('email'))
                                    <div id="email-error" class="error text-danger pl-3" for="email"
                                        style="display: block;">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="bmd-form-group{{ $errors->has('password') ? ' has-danger' : '' }} mt-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="material-icons">lock_outline</i>
                                        </span>
                                    </div>
                                    <input type="password" name="password" id="password" class="form-control"
                                        placeholder="{{ __('Password...') }}" required>
                                </div>
                                @if ($errors->has('password'))
                                    <div id="password-error" class="error text-danger pl-3" for="password"
                                        style="display: block;">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div
                                class="bmd-form-group{{ $errors->has('password_confirmation') ? ' has-danger' : '' }} mt-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="material-icons">lock_outline</i>
                                        </span>
                                    </div>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="form-control" placeholder="{{ __('Confirm Password...') }}" required>
                                </div>
                                @if ($errors->has('password_confirmation'))
                                    <div id="password_confirmation-error" class="error text-danger pl-3"
                                        for="password_confirmation" style="display: block;">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer justify-content-center">
                            <button type="submit"
                                class="btn btn-primary btn-link btn-lg">{{ __('Reset Password') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
