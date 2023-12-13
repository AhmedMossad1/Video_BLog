@extends('back-end.layout.app')

@section('title')
{{-- {{$pageTitle}} --}}
@endsection
@section('content')
    @component('back-end.layout.header')
        @slot('nav_title')
        {{-- {{$pageTitle}} --}}
        @endslot
    @endcomponent
<div class="row">
    <div class="col-md-8">
        <div class="card">
        <div class="card-header card-header-primary">
            {{-- <h4 class="card-title">{{$pageTitle}}</h4>
            <p class="card-category">{{$pageDes}}</p> --}}
        </div>
        <div class="card-body">
            <form method="POST" action="{{route('users.store')}}">
            @include('back-end.users.form')
            <button type="submit" class="btn btn-primary pull-right">Add </button>
            <div class="clearfix"></div>
            </form>
        </div>
        </div>
    </div>
</div>


@endsection
