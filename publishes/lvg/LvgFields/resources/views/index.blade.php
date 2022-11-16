@extends('fields::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>
        This view is loaded from lvg: {!! config('fields.name') !!}
    </p>
@endsection
