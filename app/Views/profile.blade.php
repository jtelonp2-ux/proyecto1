@extends('layout')

@section('contenido')
    <h1>{{ lang('App.profile') }}</h1>

    <img src="{{ $usuario['photo'] ? '/uploads/avatars/' . $usuario['photo'] : '/uploads/default.svg' }}"
         alt="Avatar" width="150" height="150"><br>

    @if ($usuario['photo'])
        <a href="/profile/image/delete">{{ lang('App.deleteImage') }}</a>
    @endif

    <p><strong>{{ lang('App.name') }}</strong><br>{{ $usuario['name'] }}</p>
    <p><strong>{{ lang('App.email') }}</strong><br>{{ $usuario['email'] }}</p>

    <a href="/profile/confirm">{{ lang('App.edit') }}</a>
    <a href="/profile/password">{{ lang('App.changePassword') }}</a>
    <a href="/profile/image">{{ lang('App.changeImage') }}</a>
@endsection