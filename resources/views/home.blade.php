@extends('layouts.main')

@push('header')
    <div class="search-block">
        <div class="container">
            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
            <input id="search" type="text" placeholder="Search for username, first name, last name, videos, photos etc.." />
        </div>
    </div>
@endpush
@section('content')
    <div class="container" id="home-container">
        <p class="headline">Videos: <span class="count">36</span></p>
        <div class="row">
            @include('_partials.video_block')
        </div>
    </div>
@endsection
