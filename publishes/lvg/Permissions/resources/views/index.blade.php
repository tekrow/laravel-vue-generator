@extends('permissions::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>
        This view is loaded from lvg: {!! config('permissions.name') !!}
    </p>
@endsection
