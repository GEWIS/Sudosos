@extends('master')

@section('page-content')
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4 class="text-center" style="font-size:20px;">SudoSOS - Register Maestro</h4>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST"
                              action="{{ action('Auth\RegisterController@doRegister') }}">
                            {!! csrf_field() !!}

                            <div class="row">
                                <div class="col-xs-10 col-xs-offset-1 text-center margin-bottom-15 background-strikethrough">
                                    <span>Enter Personal Details</span>
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('first_name') ? ' has-error' : '' }}">
                                <div class="col-xs-10 col-xs-offset-1">
                                    <input type="text" class="form-control" name="first_name"
                                           value="{{ old('first_name') }}" placeholder="First Name">
                                    {{--@if ($errors->has('first_name'))--}}
                                        {{--<span class="help-block">--}}
                                        {{--<strong>{{ $errors->first('first_name') }}</strong>--}}
                                    {{--</span>--}}
                                    {{--@endif--}}
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                                <div class="col-xs-10 col-xs-offset-1">
                                    <input type="text" class="form-control" name="last_name"
                                           value="{{ old('last_name') }}" placeholder="Last Name">
                                    {{--@if ($errors->has('last_name'))--}}
                                        {{--<span class="help-block">--}}
                                        {{--<strong>{{ $errors->first('last_name') }}</strong>--}}
                                    {{--</span>--}}
                                    {{--@endif--}}
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <div class="col-xs-10 col-xs-offset-1">
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                                        placeholder="Email Address">
                                    {{--@if ($errors->has('email'))--}}
                                        {{--<span class="help-block">--}}
                                        {{--<strong>{{ $errors->first('email') }}</strong>--}}
                                    {{--</span>--}}
                                    {{--@endif--}}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-10 col-xs-offset-1 text-center margin-bottom-15 background-strikethrough">
                                    <span>Enter Your Password</span>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <div class="col-xs-10 col-xs-offset-1">
                                    <input type="password" class="form-control" name="password" placeholder="Password">
                                    {{--@if ($errors->has('password'))--}}
                                        {{--<span class="help-block">--}}
                                        {{--<strong>{{ $errors->first('password') }}</strong>--}}
                                    {{--</span>--}}
                                    {{--@endif--}}
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <div class="col-xs-10 col-xs-offset-1">
                                    <input type="password" class="form-control" name="password_confirmation"
                                           placeholder="Confirm Password">
                                    {{--@if ($errors->has('password_confirmation'))--}}
                                        {{--<span class="help-block">--}}
                                        {{--<strong>{{ $errors->first('password_confirmation') }}</strong>--}}
                                    {{--</span>--}}
                                    {{--@endif--}}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-10 col-xs-offset-1 text-center margin-bottom-15 background-strikethrough">
                                    <span> Why do you want an account?</span>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('comment') ? ' has-error' : '' }}">
                                  <div class="col-xs-10 col-xs-offset-1">
                                    <textarea name="comment" placeholder="Type here..." style="padding:6px 12px;width:100%;"></textarea>
                                    {{--@if ($errors->has('comment'))--}}
                                        {{--<span class="help-block">--}}
                                        {{--<strong>{{ $errors->first('comment') }}</strong>--}}
                                    {{--</span>--}}
                                    {{--@endif--}}
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-xs-10 col-xs-offset-1">
                                    <button type="submit" class="btn btn-lg btn-primary full-width">
                                        <i class="fa fa-btn fa-user"></i>Register
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop