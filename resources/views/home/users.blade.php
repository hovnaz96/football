@extends('layouts.home')

@push('css')
    <link rel="stylesheet" href="{{ asset('home/style/magnific.css') }}">
@endpush

@section('content')
    <div id="content-block" class="home">
        <div class="head-bg">
            <div class="head-bg-img"  style="background:url({{ $Site->background_image }}) center"></div>
            <div class="head-bg-content">
                <h1>{{ $Site->welcome_text }}</h1>
                <p>{{ $Site->sub_welcome_text }}</p>
                @if(Auth::guest())
                    <a class="be-register btn color-3 size-1 hover-6"><i class="fa fa-lock"></i>sign up now</a>
                @endif
            </div>
        </div>

        <div class="container-fluid custom-container home" >

            <div class="row">
                <div class="col-md-12" style="margin-bottom: 40px; overflow: hidden">
                    <div class="col-sm-6 col-xs-12 padding-0" style="margin-bottom: 20px">
                        <p class="title" style="padding-top: 10px;"> Users </p>
                    </div>
                    <div class="col-sm-3 col-xs-12 left-feild pull-right">
                        <form action="./" class="input-search" style="margin-bottom: 0;">
                            <input type="text" placeholder="Enter name" class="search-user">
                            <i class="fa fa-search"></i>
                            <input type="submit" value="">
                        </form>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="container-fluid custom-container">
                        <div class="row">
                            <div class="col-md-12 ">
                                <div id="container-mix" class="be-user-wrapper row users">
                                    @foreach($users as $user)
                                        <div class="category-2 custom-column-2 col-lg-2 col-sm-6 user">
                                            <div class="be-user-block style-2 be-user-block-foreach">
                                                <a class="be-ava-user style-2 href-not" href="{{ $user->user_profile_url }}">
                                                    <img src="{{ $user->user_profile_image_large }}" alt="">
                                                </a>
                                                <div class="be-user-counter">
                                                    <div class="c_number">{{ $user->user_project_count }}</div>
                                                    <div class="c_text">materials</div>
                                                </div>
                                                <a href="{{ $user->user_profile_url }}" class="be-use-name user-name href-not">{{ $user->full_name }}</a>
                                                <p class="be-user-info">{{ $user->birth_place }}</p>
                                                {{--@if(Auth::user()->id != $followers->userFollowing->id)--}}
                                                    {{--<a class="btn color-1 size-2 hover-1 follow {{ $user->checkIsFollowed($followers->user_id)?'unfollow':'isfollowing' }}" data-id="{{ $followers->user_id }}"><span>{{ $user->checkIsFollowed($followers->user_id)?'UNFOLLOW':'FOLLOW' }}</span></a>--}}
                                                {{--@endif--}}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('after-js')
    <script>
        $(document).ready(function(){
            @if(!Auth::check())
                $(document).ready(function(){
                    $(document).on('click','.href-not',function(e){
                        e.preventDefault();
                        $('.btn-login').trigger('click');
                    });
                });
            @endif

            $(document).on('keyup','.search-user',function(){
                var input, filter, ul, li, a, i;
                input = $(this);
                filter = input.val().toUpperCase();
                ul = $('.users');
                li = ul.find('.user');

                // Loop through all list items, and hide those who don't match the search query
                for (i = 0; i < li.length; i++) {
                    label = li[i].getElementsByClassName('user-name')[0];
                    if (label.innerText.toUpperCase().indexOf(filter) > -1) {
                        li[i].style.display = "";
                    } else {
                        li[i].style.display = "none";
                    }
                }
            });
        })
    </script>
@endpush

