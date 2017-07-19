@extends('master')

@section('page-content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3 col-xs-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4 class="text-center" style="font-size:20px;">SudoSOS - Login Maestro</h4>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6 col-xs-12">
                                <a href="{{ action('Auth\LoginController@showGEWISLogin') }}">
                                    <div class="thumbnail thumbnail-gewis">
                                        <img src="../../img/gewislogo.svg" alt="GEWIS logo"
                                             class="img-responsive center-block">
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-6 col-xs-12">
                                <a href="{{ action('Auth\LoginController@showExternalLogin') }}">
                                    <div class="thumbnail thumbnail-gewis">
                                        <img src="../../img/external.svg" alt="GEWIS logo"
                                             class="img-responsive center-block">
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop