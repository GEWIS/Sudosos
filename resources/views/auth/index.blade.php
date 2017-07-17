@extends('master')

@section('page-content')
    <a href="{{ action('Auth\LoginController@showGEWISLogin') }}">
        GEWIS Login
    </a>
    <br>
    <a href="{{ action('Auth\LoginController@showExternalLogin') }}">
        External Login
    </a>
    @stop