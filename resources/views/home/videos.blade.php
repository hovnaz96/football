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
                <p class="title"> Videos</p>
                <div class="col-md-12">
                    <div id="container-mix" class="row _post-container_">
                        <div class="popup-video">
                            @foreach($videos as $video)
                                <div class="category-1 custom-column-5 video-post-home" data-id="{{ $video->id }}">
                                    <div class="be-post">
                                        <section href="{{ $video->video_url }}" class="be-img-block" title="{{ $video->user->full_name }}">
                                            <img src="{{ $video->url_video_thumbnail }}" alt="omg">
                                        </section>
                                        <div class="author-post">
                                            <img src="{{ $video->user->user_profile_image_small }}" alt="" class="ava-author">
                                            <span>by <a class='href-not' href="{{ route('user.profile',['slug'=>$video->user->slug])  }}">{{ $video->user->full_name }}</a></span>
                                        </div>
                                        <div class="info-block">
                                            @php
                                                $user = new \App\Models\User();
                                                $isLikedVideo = $user->isLikedVideo($video->id);
                                            @endphp

                                            <span data-id="{{ $video->id }}" class="like-video {{ $isLikedVideo?'active-like':'' }}"><i class="fa fa-thumbs-o-up"></i><span>{{ $video->video_likes_count }}</span> </span>
                                            <span><i class="fa fa-eye"></i> {{ $video->views }} </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('after-js')
    <script src="{{ asset('home/script/magnific.js') }}"></script>
    <script>
        @if(Auth::check())
        $(document).ready(function(){
            var loading_video = false;
            $(document).on('click','.like-video',function(){
                if(loading_video){
                    return false;
                }
                loading_video = true;
                var data_video_id = $(this).data('id');
                var $self = $(this);
                $.ajax({
                    url:'{!!  route('user.like.video') !!}',
                    type:'POST',
                    data:
                        {
                            video_id:data_video_id,
                            _token:'{!! csrf_token() !!} '
                        },
                    success:function()
                    {
                        var old_like_count = parseInt($self.find('span').text());
                        if(old_like_count < 0){
                            return false;
                        }
                        if($self.hasClass('active-like')){
                            $self.find('span').text(old_like_count-1);
                        }else{
                            $self.find('span').text(old_like_count+1);
                        }

                        $self.toggleClass('active-like');
                        loading_video = false;
                    },
                    error:function(res)
                    {

                    }
                })
            });
        })
        @else
        $(document).ready(function(){
            $(document).on('click','.like-video,.href-not',function(e){
                e.preventDefault();
                $('.btn-login').trigger('click');
            });
        })
        @endif



        $(document).ready(function(){

            $('.video-post-home').click(function(){
                $.ajax({
                    url:"{{ route('video.view') }}",
                    method:'POST',
                    data:{
                        _token:'{!! csrf_token() !!}',
                        video_id:$(this).data('id')
                    },
                    success:function(){

                    },
                    error:function(){

                    }
                })
            });


            $('.popup-video').magnificPopup({
                delegate: 'section',
                type: 'iframe',
                tLoading: 'Loading image #%curr%...',
                mainClass: 'mfp-img-mobile',
                iframe: {
                    markup: '<div class="mfp-iframe-scaler your-special-css-class">'+
                    '<div class="mfp-close"></div>'+
                    '<iframe class="mfp-iframe" frameborder="0" allowfullscreen allowtransparency></iframe>'+
                    '</div>'
                },
                callbacks: {
                    open: function() {
                        $('.mfp-iframe').contents().find('body').css('background','#333');
                    }
                }
            });
        });

    </script>
@endpush

