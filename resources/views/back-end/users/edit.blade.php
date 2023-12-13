@extends('back-end.layout.app')
@section('title')
{{$pageTitle}}
@endsection
@section('content')
    @component('back-end.layout.header')
        @slot('nav_title')
        {{$pageTitle}}
        @endslot
    @endcomponent
    @component('back-end.shared.edit' , ['pageTitle' => $pageTitle , 'pageDes' => $pageDes])
    <div class="card-body">
        <form method="POST" action="{{route('users.update',$row->id)}}">
            @method('PUT')
        @include('back-end.users.form')
        <button type="submit" class="btn btn-primary pull-right"> Update </button>
        <div class="clearfix"></div>
        </form>
    </div>
    @endcomponent

@endsection
