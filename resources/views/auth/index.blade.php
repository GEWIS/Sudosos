@extends('master')

@section('page-content')
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4 class="text-center" style="font-size:20px;">SudoSOS - Login Maestro</h4>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 text-center margin-bottom-15 background-strikethrough">
                                <span> Login as GEWIS member </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 margin-bottom-15">
                                <a href="{{ action('Auth\LoginController@showGEWISLogin') }}">
                                    <div class="btn btn-lg btn-primary full-width">
                                        GEWIS Login
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 text-center margin-bottom-15 background-strikethrough">
                                <span> Or as external user </span>
                            </div>
                        </div>

                        <form class="form-horizontal" role="form" method="POST"
                              action="{{ action('Auth\LoginController@doExternalLogin') }}">
                            {!! csrf_field() !!}

                            @if (isset($error))
                                <div class="form-group form-group-lg">
                                    <div class="col-xs-10 col-xs-offset-1 text-center">
                                        <span class="full-width text-primary">
                                        {{ $error }}
                                        </span>
                                    </div>
                                </div>
                            @endif
                            <div class="form-group form-group-lg {{ $errors->has('username') ? 'has-error' : '' }}">
                                <div class="col-xs-10 col-xs-offset-1">
                                    <input type="username" class="form-control" name="username"
                                           placeholder="Email / Usercode" value="{{ old('username') }}">
                                    {{--<label class="col-md-4 control-label">E-Mail / Usercode</label>--}}
                                    {{----}}
                                    {{--<div class="col-md-6">--}}
                                    {{--<input type="username" class="form-control" name="username" value="{{ old('username') }}">--}}

                                    {{--@if ($errors->has('username'))--}}
                                    {{--<span class="help-block">--}}
                                    {{--<strong>{{ $errors->first('username') }}</strong>--}}
                                    {{--</span>--}}
                                    {{--@endif--}}
                                    {{--</div>--}}
                                </div>
                            </div>
                            <div class="form-group form-group-lg {{ $errors->has('password') ? 'input-danger' : '' }}">
                                <div class="col-xs-10 col-xs-offset-1">
                                    <input type="password" class="form-control" placeholder="Password"
                                           name="password">
                                    {{--@if ($errors->has('password'))--}}
                                        {{--<span class="help-block">--}}
                                    {{--<strong>{{ $errors->first('password') }}</strong>--}}
                                    {{--</span>--}}
                                    {{--@endif--}}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-10 col-xs-offset-1">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember"> Remember Me
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-10 col-xs-offset-1">
                                    <button type="submit" class="btn btn-lg btn-primary full-width">External Login</button>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-10 col-xs-offset-1">
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <a class="btn btn-link"
                                               style="text-align:left; white-space:pre-line; padding:0px;"
                                               href="/todo">Forgot Password?</a>
                                        </div>
                                        <div class="col-xs-6 text-right">
                                            <a class="btn btn-link"
                                               style="padding:0px; white-space:pre-line; text-align:right;"
                                               href="/todo">Request External
                                                Account</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop