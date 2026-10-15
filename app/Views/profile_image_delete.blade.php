@extends('layout')

@section('contenido')
    <h1>{{ lang('App.deleteImage') }}</h1>
    <p>{{ lang('App.areYouSure') }}</p>

    <form action="/profile/image/delete" method="post">
        {!! csrf_field() !!}

        <button type="submit">{{ lang('App.save') }}</button>
        <a href="/profile">{{ lang('App.cancel') }}</a>
    </form>
@endsection