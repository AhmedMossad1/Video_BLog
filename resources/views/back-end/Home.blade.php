@extends('back-end.layout.app')
@section('title')
@endsection
@section('content')
@component('back-end.layout.header')
@slot('nav_title')
Home Page
@endslot

@endcomponent
<h1>Home</h1>
@endsection
