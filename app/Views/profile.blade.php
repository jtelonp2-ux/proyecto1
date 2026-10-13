@extends('layout')

@section('contenido')
    <h1>Profile</h1>

    <p><strong>Name</strong><br>{{ $usuario['name'] }}</p>
    <p><strong>Email</strong><br>{{ $usuario['email'] }}</p>
@endsection