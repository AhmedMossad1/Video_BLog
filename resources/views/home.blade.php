@extends('layouts.app')

@section('content')
    <div class="section section-buttons">
        <div class="container">
            <div class="title">
                <h2>Latest videos</h2>
                @if (request()->has('search') && request()->get('search') != '')
                Search Result : <b>{{request()->get('search')}} </b> | <a href="{{route('home')}}">Rest</a>

                @endif
            </div>
            @include('front-end.shared.video-row')
        </div>
    </div>
@endsection
