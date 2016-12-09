@extends('layouts.app')

@section('content')

<h3>Unauthorized!</h3>

<p>{{ $exception->getMessage() }}</p>

@endsection