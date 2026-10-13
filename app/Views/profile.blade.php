@extends('layout')

@section('contenido')
    <h1>Profile</h1>

    <p><strong>Name</strong><br>{{ $usuario['name'] }}</p>
    <p><strong>Email</strong><br>{{ $usuario['email'] }}</p>

    <a href="/profile/confirm">Edit</a>
    <a href="/profile/password">Change password</a>
@endsection