@extends('layout')

@section('contenido')
    <h1>Forgot password</h1>

    <form action="/forgot-password" method="post">
        {!! csrf_field() !!}

        <label for="email">{{ lang('App.email') }}</label><br>
        <input type="email" id="email" name="email" value="{{ old('email') }}"><br><br>

        <button type="submit">{{ lang('App.send') }}</button>
        <a href="/login">{{ lang('App.cancel') }}</a>
    </form>
@endsection