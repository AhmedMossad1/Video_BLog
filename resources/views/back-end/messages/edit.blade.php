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

            @include('back-end.'.$folderName.'.form')


    </div>
    @endcomponent

@endsection
