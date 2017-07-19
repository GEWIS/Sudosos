@extends('master')
@section('page-content')
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4 class="text-center">SudoSOS - External Login</h4>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST"
                              action="{{ action('Auth\LoginController@doExternalLogin') }}">
                            {!! csrf_field() !!}
                            @if (isset($error))
                                {{ $error }}
                            @endif
                            <div class="form-group">
                                <div class="col-xs-10 col-xs-offset-1">
                                    <div class="input-group input-group-lg{{ $errors->has('username') ? 'has-error' : '' }}">
                                        <input type="username" class="form-control" name="username"
                                               placeholder="Email / Usercode" value="{{ old('username') }}">
                                        <span class="input-group-addon"></span>
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
                            </div>
                            <div class="form-group">
                                <div class="col-xs-10 col-xs-offset-1">
                                    <div class="input-group input-group-lg{{ $errors->has('password') ? ' has-error' : '' }}">
                                        <input type="password" class="form-control" placeholder="Password"
                                               name="password">
                                        <span class="input-group-addon"> </span>
                                        {{--<div class="col-md-6">--}}
                                        {{--<input type="password" class="form-control" name="password">--}}

                                        {{--@if ($errors->has('password'))--}}
                                        {{--<span class="help-block">--}}
                                        {{--<strong>{{ $errors->first('password') }}</strong>--}}
                                        {{--</span>--}}
                                        {{--@endif--}}
                                        {{--</div>--}}
                                        {{--</div>--}}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" style="margin-top:30px;">
                                <div class="col-xs-10 col-xs-offset-1">
                                    <button type="submit" class="btn btn-lg btn-primary full-width">Login</button>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-10 col-xs-offset-1">
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <a class="btn btn-link" style="padding:0px;" href="/todo">Forgot
                                                Password?</a>
                                        </div>
                                        <div class="col-xs-6 text-right">
                                            <a class="btn btn-link" style="padding:0px;" href="/todo">Request
                                                Account</a>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            {{--<div class="form-group">--}}
                            {{--<div class="col-md-6 col-md-offset-4">--}}
                            {{--<div class="checkbox">--}}
                            {{--<label>--}}
                            {{--<input type="checkbox" name="remember"> Remember Me--}}
                            {{--</label>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--</div>--}}

                            {{--<div class="form-group">--}}
                            {{--<div class="col-md-6 col-md-offset-4">--}}
                            {{--<button type="submit" class="btn btn-primary">--}}
                            {{--<i class="fa fa-btn fa-sign-in"></i>Login--}}
                            {{--</button>--}}

                            {{--<a class="btn btn-link" href="/todo">Forgot Your Password?</a>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection