@extends('schematics::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>
        This view is loaded from lvg: {!! config('schematics.name') !!}
    </p>
@endsection
