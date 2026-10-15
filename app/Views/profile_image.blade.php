@extends('layout')

@section('contenido')
    <h1>{{ lang('App.editImage') }}</h1>

    @if (session('errors'))
        <ul>
            @foreach (session('errors') as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="/profile/image" method="post" enctype="multipart/form-data">
        {!! csrf_field() !!}

        <input type="file" name="photo" accept="image/png,image/jpeg,image/webp"><br><br>

        <button type="submit">{{ lang('App.save') }}</button>
        <a href="/profile">{{ lang('App.cancel') }}</a>
    </form>
@endsection