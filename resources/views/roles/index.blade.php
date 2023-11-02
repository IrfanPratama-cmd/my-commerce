@extends('layout.main')

@section('container')
    @can('create-role')
        <button class="btn btn-primary">Create</button>
    @endauth
@endsection
