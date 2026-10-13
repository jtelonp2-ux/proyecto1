@extends('layout')

@section('contenido')
    <h1>Please enter your password to continue</h1>

    @if (session('error'))
        <p>{{ session('error') }}</p>
    @endif

    <form action="/profile/confirm" method="post">
        {!! csrf_field() !!}

        <label for="password">Password</label><br>
        <input type="password" id="password" name="password"><br><br>

        <button type="submit">Send</button>
        <a href="/profile">Cancel</a>
    </form>
@endsection