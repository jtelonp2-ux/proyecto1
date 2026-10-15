@extends('layout')

@section('contenido')
    <h1>{{ lang('App.profile') }}</h1>

    <p><strong>{{ lang('App.name') }}</strong><br>{{ $usuario['name'] }}</p>
    <p><strong>{{ lang('App.email') }}</strong><br>{{ $usuario['email'] }}</p>

    <a href="/profile/confirm">{{ lang('App.edit') }}</a>
    <a href="/profile/password">{{ lang('App.changePassword') }}</a>
@endsection