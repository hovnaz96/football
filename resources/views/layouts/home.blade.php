<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
        ga('create', 'UA-105353157-1', 'auto');
        ga('require', 'GTM-NPMZBRP');
        ga('send', 'pageview');
    </script>
    <style>.async-hide { opacity: 0 !important} </style>
    <script>(function(a,s,y,n,c,h,i,d,e){s.className+=' '+y;h.start=1*new Date;
            h.end=i=function(){s.className=s.className.replace(RegExp(' ?'+y),'')};
            (a[n]=a[n]||[]).hide=h;setTimeout(function(){i();h.end=null},c);h.timeout=c;
        })(window,document.documentElement,'async-hide','dataLayer',4000,
            {'GTM-NPMZBRP':true});</script>
    <title>{{ $Site->title }}</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="{{ $Site->favicon }}"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta NAME="ROBOTS" CONTENT="INDEX, FOLLOW" />
    <meta name="Description" content="{{ $Site->about_us }}" />
    <meta name="Keywords" content="football, scout, football scout, video, photo, profile, follow, messages, team, my team, my profile, dream, dream team" />
    <meta property="og:title" content="{{ $Site->title }}" />
    <meta property="og:description" content="Find your dream team, upload video photo, follow, messaging, your page." />
    <meta property="og:image" content="{{ $Site->logo }}" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('home/style/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('home/style/icon.css') }}"/>
    {{--<link rel="stylesheet" href="{{ asset('home/style/loader.css') }}"/>--}}
    <link rel="stylesheet" href="{{ asset('home/style/idangerous.swiper.css') }}">
    <link rel="stylesheet" href="{{ asset('home/style/stylesheet.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}"/>
    @stack('css')
</head>
<body>
<header>
    <div class="container-fluid custom-container">
        <div class="row no_row row-header">
            <div class="brand-be">
                <a href="{{  url('/') }}">
                    <img class=" be_logo logo-c active" src="{{ $Site->logo }}" alt="logo">
                </a>
            </div>
            @if(Auth::check())
                <div class="login-header-block">
                    <div class="be-drop-down login-user-down visible-sm visible-xs visible-lg-x responsive-margin">
                        <img class="login-user" src="{{ Auth::user()->user_profile_image_medium }}" alt="">

                        <span class="be-dropdown-content hidden-xs">Hi, <span>{{ Auth::user()->full_name}}</span></span>
                        <div class="drop-down-list a-list responsive-drop">
                            <a href="{{ route('user.profile',['slug'=>Auth::user()->slug]) }}">My Profile</a>
                            @if(Auth::user()->isAdmin)
                                <a href="{{ url('/superuser') }}">Admin Dashboard</a>
                            @endif
                            <a href="{{ route('messages') }}">View Messages</a>
                            <a href="{{ route('user.edit') }}">Account Settings</a>
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                  style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </div>
                    <div class="login_block hidden-lg-x">
                        <a class="messages-popup" href="">
                            <i class="fa fa-envelope-o"></i>
                            <span class="noto-count"><i class="fa fa-info"></i></span>
                        </a>
                        <div class="noto-popup messages-block">
                            <div class="m-close"><i class="fa fa-times"></i></div>
                            <div class="noto-label">Your Messages <span class="noto-label-links"><a
                                            href="{{ route('messages') }}">View all messages</a></span></div>
                            <div class="noto-body" id="chat-header">
                                <messages-header :message_users="message_users"></messages-header>
                            </div>
                        </div>
                        <div class="be-drop-down login-user-down hidden-lg-x">
                            <img class="login-user" src="{{ Auth::user()->user_profile_image_medium }}" alt="">

                            <span class="be-dropdown-content">Hi, <span>{{ Auth::user()->full_name}}</span></span>
                            <div class="drop-down-list a-list">
                                <a href="{{ route('user.profile',['slug'=>Auth::user()->slug]) }}">My Profile</a>
                                @if(Auth::user()->isAdmin)
                                    <a href="{{ url('/superuser') }}">Admin Dashboard</a>
                                @endif
                                <a href="{{ route('user.edit') }}">Account Settings</a>
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">Logout</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="login-header-block">
                    <div class="login_block">
                        <a class="btn-login btn color-1 size-2 hover-2" href=""><i class="fa fa-user"></i>
                            Log in</a>
                    </div>
                </div>
            @endif
            <div class="header-menu-block">
                <button class="cmn-toggle-switch cmn-toggle-switch__htx"><span></span></button>
                <ul class="header-menu" id="one">
                    @if(Auth::check())
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><a href="{{ route('user.profile',['slug'=>Auth::user()->slug]) }}">Profile</a></li>
                    @endif
                    <li><a href="{{ route("videos") }}">Videos</a></li>
                    <li><a href="{{ route("photos") }}">Photos</a></li>
                    <li><a href="{{ route("users") }}">Users</a></li>
                </ul>
            </div>
        </div>
    </div>
</header>

@yield('content')


<footer>
    <div class="footer-main">
        <div class="container-fluid custom-container">
            <div class="row">
                <div class="col-md-6 col-xl-6">
                    <div class="footer-block">
                        <h1 class="footer-title">About Us</h1>
                        <p>{{ $Site->about_us }}</p>
                        <ul class="soc_buttons">
                            @if($Site->facebook)
                                <li><a href="{{ $Site->facebook }}"><i class="fa fa-facebook"></i></a></li>
                            @endif
                            @if($Site->twitter)
                                <li><a href="{{ $Site->twitter }}"><i class="fa fa-twitter"></i></a></li>
                            @endif
                            @if($Site->google_plus)
                                <li><a href="{{ $Site->google_plus }}"><i class="fa fa-google-plus"></i></a></li>
                            @endif
                            @if($Site->instagram)
                                <li><a href="{{ $Site->instagram }}"><i class="fa fa-instagram"></i></a></li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="footer-block">
                        <h1 class="footer-title">Subscribe On Our News</h1>
                        <form action="./" class="subscribe-form">
                            <input type="text" placeholder="Your Name" required>
                            <div class="submit-block">
                                <i class="fa fa-envelope-o"></i>
                                <input type="submit" value="">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container-fluid custom-container">
            <div class="col-md-12 footer-end clearfix">
                <div class="left">
                    <span class="copy">© 2017. All rights reserved. {{--<span class="white"><a href="javascript:void(0)"> </a></span>--}}</span>
                    {{--<span class="created">--}}{{--<span class="white"><a href="javascript:void(0)"></a></span>--}}{{--</span>--}}
                </div>
                {{--<div class="right">--}}
                    {{--<a class="btn color-7 size-2 hover-9">About Us</a>--}}
                    {{--<a class="btn color-7 size-2 hover-9">Help</a>--}}
                    {{--<a class="btn color-7 size-2 hover-9">Privacy Policy</a>--}}
                {{--</div>--}}
            </div>
        </div>
    </div>
</footer>
<div class="be-fixed-filter"></div>
@if(Auth::guest())
    @include('_partials.auth.login')
    @include('_partials.auth.register')
@endif
@stack('js')
@if(Auth::check())
    <script src="{{ asset('js/app.js') }}"></script>
@endif
<script src="{{ asset('home/script/jquery-2.1.4.min.js') }}"></script>
<script src="{{ asset('home/script/bootstrap.min.js') }}"></script>
<script src="{{ asset('home/script/idangerous.swiper.min.js') }}"></script>
<script src="{{ asset('home/script/jquery.mixitup.js') }}"></script>
<script src="{{ asset('home/script/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('home/script/jquery.viewportchecker.min.js') }}"></script>
<script src="{{ asset('home/script/global.js') }}"></script>
<script src="{{ asset('home/script/main.js') }}"></script>
@stack('after-js')
</body>
</html>