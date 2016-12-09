@extends('layouts.app')

@section('content')

<h3>404 - not found</h3>

<p>{{ $exception->getMessage() }}</p>

@endsection