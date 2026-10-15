@extends('layout')

@section('contenido')
    <h1>{{ lang('App.enterPassword') }}</h1>

    <form action="/profile/confirm" method="post">
        {!! csrf_field() !!}

        <label for="password">{{ lang('App.password') }}</label><br>
        <input type="password" id="password" name="password"><br><br>

        <button type="submit">{{ lang('App.send') }}</button>
        <a href="/profile">{{ lang('App.cancel') }}</a>
    </form>
@endsection