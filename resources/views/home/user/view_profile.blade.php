@extends('layouts.home')

@push('css')
    <link rel="stylesheet" href="{{ asset('home/style/magnific.css') }}">
@endpush
@section('content')
    <div id="content-block">
        <div class="container be-detail-container">
            <div class="row">
                <div class="col-xs-12 col-md-4 left-feild">
                    <div class="be-user-block style-3">
                        <div class="be-user-detail">
                            <a class="be-ava-user style-2" href="{{ route('user.edit') }}">
                                <img src="{{ $user->user_profile_image_large }}" alt="">
                            </a>
                            @if(Auth::check() && Auth::user()->id == $user->id)
                            <a class="be-ava-left btn color-1 size-2 hover-1 button-responsive" href="{{ route('user.edit') }}"><i
                                        class="fa fa-pencil"></i>Edit</a>
                            @elseif(Auth::check() && Auth::user()->id != $user->id)
                                <span data-id='{{ $user->id }}' class="{{ $user->is_following?'unfollow':'isfollowing' }} button-responsive follow be-ava-left btn color-1 size-2 hover-1">
                                    <i class="fa fa-plus"></i><span>{{ $user->is_following?'UNFOLLOW':'FOLLOW' }} </span></span>
                            @endif

                            @if(Auth::check() && Auth::user()->id != $user->id)
                                <a href="blog-detail-2.html" id="message-id" data-id="{{ $user->id }}"
                                   class="col-lg-6 be-user-activity-button send-btn be-message-type"><i
                                            class="fa fa-envelope-o"></i>MESSAGE</a>
                            @endif
                            <p class="be-use-name">{{ $user->full_name }}</p>

                            @if(!is_null($user->birthplace))
                                <div class="be-user-info">
                                    {{ $user->birthplace }}
                                </div>
                            @endif

                            @if(!is_null($user->personal_info->occupation))
                                <div class="be-text-tags style-2">
                                    <a href="#">{{ $user->personal_info->occupation }}</a>
                                </div>
                            @endif

                            @if(!is_null($user->social_links))
                                <div class="be-user-social">
                                    @foreach($user->social_links->getAttributes() as $key=>$link)
                                        @if ($key == 'facebook' && !is_null($link))
                                            <a class="social-btn color-1" href="{{ $link }}"><i class="fa fa-facebook"></i></a>
                                        @elseif ($key == 'twitter' && !is_null($link))
                                            <a class="social-btn color-2" href="{{ $link }}"><i class="fa fa-twitter"></i></a>
                                        @elseif ($key == 'google_plus' && !is_null($link))
                                            <a class="social-btn color-3" href="{{ $link }}"><i class="fa fa-google-plus"></i></a>
                                        @elseif ($key == 'instagram' && !is_null($link))
                                            <a class="social-btn color-5" href="{{ $link }}"><i class="fa fa-instagram"></i></a>
                                        @endif
                                    @endforeach
                                    {{--<a class="social-btn color-4" href="page1.html"><i class="fa fa-pinterest-p"></i></a>--}}
                                    {{--<a class="social-btn color-6" href="page1.html"><i class="fa fa-linkedin"></i></a>--}}
                                </div>
                            @endif

                        </div>
                        <div class="be-user-statistic">
                            <div class="stat-row clearfix"><i class="stat-icon icon-views-b"></i> Projects views<span
                                        class="stat-counter">{{ $views }}</span></div>
                            <div class="stat-row clearfix"><i class="stat-icon icon-like-b"></i>Appreciations<span
                                        class="stat-counter">{{ $likes }}</span></div>
                            <div class="stat-row clearfix"><i class="stat-icon icon-followers-b"></i>Followers<span
                                        class="stat-counter">{{ $user->followers_relation_count }}</span></div>
                            <div class="stat-row clearfix"><i class="stat-icon icon-following-b"></i>Following<span
                                        class="stat-counter">{{ $user->following_relation_count }}</span></div>
                        </div>
                    </div>
                    <div class="be-desc-block">
                        <div class="be-desc-author">
                            <div class="be-desc-label">   {{ $user->full_name }}</div>
                            <div class="clearfix"></div>
                            <div class="be-desc-text">
                                {{ $user->personal_info->occupation }}
                            </div>
                        </div>
                        <div class="be-desc-author">
                            <div class="be-desc-label">About Me</div>
                            <div class="clearfix"></div>
                            <div class="be-desc-text">
                                {{ $user->personal_info->description }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-8">
                    <div class="tab-wrapper style-1">
                        <div class="tab-nav-wrapper">
                            <div class="nav-tab  clearfix">
                                <div class="nav-tab-item active">
                                    <span>Photos </span>
                                </div>
                                <div class="nav-tab-item ">
                                    <span>Videos</span>
                                </div>
                                <div class="nav-tab-item ">
                                    <span>Followers</span>
                                </div>
                                <div class="nav-tab-item ">
                                    <span>Following</span>
                                </div>
                                <div class="save-all-photo-block pull-right save-all-photo-click">
                                    <i class="fa fa-check save-all-photo"></i>
                                    Save All Photos
                                </div>
                                <div class="save-all-video-block pull-right save-all-video-click">
                                    <i class="fa fa-check save-all-video"></i>
                                    Save All Videos
                                </div>
                            </div>
                        </div>
                        <div class="tabs-content clearfix">
                            <div class="tab-info active" id="photo-block">
                                <form>
                                    <i class="fa fa-times error file-error"  title=""></i>
                                </form>
                                <div class="row photos-section">
                                    @if(Auth::user()->id == $user->id)
                                        <div class="col-ml-12 col-xs-6 col-sm-4 no-photo">
                                            <div class="be-post add-block-photo">
                                                <label  for="add-photo">
                                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                                    <input type="file" name="files[]" class="hidden add-photo" id="add-photo">
                                                </label>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="popup-gallery">
                                        @if(!count($user->user_all_images ) && Auth::user()->id != $user->id)
                                            <h2 class="no-materials">No Photos Yet</h2>
                                        @endif
                                        @foreach($user->user_all_images as $image)
                                            <div class="col-ml-12 col-xs-6 col-sm-4 photo-post" data-id="{{ $image->id }}">
                                                <div class="be-post">
                                                    <section href="{{ $image->url_image_original }}" class="be-img-block" title="{{ $image->user->full_name }}">
                                                        <img src="{{ $image->url_image_small }}" alt="omg">
                                                    </section>
                                                    <div class="author-post">
                                                        <img src="{{ $image->user->user_profile_image_small }}" alt="" class="ava-author">
                                                        <span>by <a href="{{ $image->user->profile_url }}">{{ $image->user->full_name }}</a></span>
                                                    </div>
                                                    <div class="info-block">
                                                        <span data-id="{{ $image->id }}" class="like-image {{ $user->isLiked($image->id)?'active-like':'' }}"><i class="fa fa-thumbs-o-up"></i><span>{{ $image->image_like_count }}</span> </span>
                                                        <span><i class="fa fa-eye"></i> {{ $image->views }} </span>
                                                    </div>
                                                    @if(Auth::user()->id == $user->id)
                                                        <div class="action-block">
                                                            <span data-id="{{ $image->id }}" class="delete-image"><i class="fa fa-times"></i>Delete</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="tab-info" id="video-block">
                                <form>
                                    <i class="fa fa-times error video-error"  title=""></i>
                                </form>
                                <div class="row videos-section">
                                    @if(Auth::user()->id == $user->id)
                                        <div class="col-ml-12 col-xs-6 col-sm-4 no-video">
                                            <div class="be-post add-block-video">
                                                <label  for="add-video">
                                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                                    <input type="file" name="files[]" class="hidden add-video" id="add-video">
                                                </label>
                                            </div>
                                        </div>
                                    @endif
                                        <div class="popup-video">
                                            @if(!count($user->user_all_videos ) &&  Auth::user()->id != $user->id)
                                                <h2 class="no-materials">No Videos Yet</h2>
                                            @endif
                                            @foreach($user->user_all_videos as $video)
                                                <div class="col-ml-12 col-xs-6 col-sm-4 video-post" data-id="{{ $video->id }}">
                                                    <div class="be-post">
                                                        <section href="{{ $video->video_url }}" class="be-img-block" title="{{ $video->user->full_name }}">
                                                            <img data-id='{{ $video->id }}' src="{{ $video->url_video_thumbnail }}" alt="omg">
                                                        </section>
                                                        <div class="author-post">
                                                            <img src="{{ $video->user->user_profile_image_small }}" alt="" class="ava-author">
                                                            <span>by <a href="{{ $video->user->user_profile_url }}">{{ $video->user->full_name }}</a></span>
                                                        </div>
                                                        <div class="info-block">
                                                            <span data-id="{{ $video->id }}" class="like-video {{ $user->isLikedVideo($video->id)?'active-like':'' }}"><i class="fa fa-thumbs-o-up"></i><span>{{ $video->video_likes_count }}</span> </span>
                                                            <span><i class="fa fa-eye"></i> {{ $video->views }} </span>
                                                        </div>
                                                        @if(Auth::user()->id == $user->id)
                                                            <div class="action-block">
                                                                <span data-id="{{ $video->id }}" class="delete-video"><i class="fa fa-times"></i>Delete</span>
                                                                <label for='thumbnail-{{ $video->id }}' data-id="{{ $video->id }}" class="thumbnail-video"><i class="fa fa-file-photo-o"></i>Thumbnail</label>
                                                                <input type="file" id="thumbnail-{{ $video->id }}" class="hidden thumbnail" >
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                </div>
                            </div>
                            <div class="tab-info">
                                <div class="container-fluid custom-container">
                                    <div class="row">
                                        <div class="col-md-12 ">
                                            <div id="container-mix" class="be-user-wrapper row">
                                                @if(!count($user->followersRelation ))
                                                    <h2 class="no-materials">No followers Yet</h2>
                                                @endif
                                                @foreach($user->followersRelation as $followers)
                                                    <div class="category-4 custom-column-4 col-sm-4">
                                                        <div class="be-user-block style-2 be-user-block-foreach">
                                                            <a class="be-ava-user style-2" href="{{ $followers->userFollowing->user_profile_url }}">
                                                                <img src="{{ $followers->userFollowing->user_profile_image_large }}" alt="">
                                                            </a>
                                                            <div class="be-user-counter">
                                                                <div class="c_number">{{ $followers->userFollowing->user_project_count }}</div>
                                                                <div class="c_text">materials</div>
                                                            </div>
                                                            <a href="{{ $followers->userFollowing->user_profile_url }}" class="be-use-name">{{ $followers->userFollowing->full_name }}</a>
                                                            <p class="be-user-info">{{ $followers->userFollowing->birth_place }}</p>
                                                            @if(Auth::user()->id != $followers->userFollowing->id)
                                                                <a class="btn color-1 size-2 hover-1 follow {{ $user->checkIsFollowed($followers->user_id)?'unfollow':'isfollowing' }}" data-id="{{ $followers->user_id }}"><span>{{ $user->checkIsFollowed($followers->user_id)?'UNFOLLOW':'FOLLOW' }}</span></a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-info">
                                <div class="container-fluid custom-container">
                                    <div class="row">
                                        <div class="col-md-12 ">
                                            <div id="container-mix" class="be-user-wrapper row">
                                                @if(!count($user->followingRelation ))
                                                    <h2 class="no-materials">No Following Yet</h2>
                                                @endif
                                                @foreach($user->followingRelation as $following)

                                                    <div class="category-4 custom-column-4 col-sm-4">
                                                        <div class="be-user-block style-2 be-user-block-foreach">
                                                            <a class="be-ava-user style-2" href="{{ $following->userFollowers->user_profile_url }}">
                                                                <img src="{{ $following->userFollowers->user_profile_image_large }}" alt="">
                                                            </a>
                                                            <div class="be-user-counter">
                                                                <div class="c_number">{{ $following->userFollowers->user_project_count }}</div>
                                                                <div class="c_text">materials</div>
                                                            </div>
                                                            <a href="{{ $following->userFollowers->user_profile_url }}" class="be-use-name">{{ $following->userFollowers->full_name }}</a>
                                                            <p class="be-user-info">{{ $following->userFollowers->birth_place }}</p>
                                                            @if(Auth::user()->id != $following->userFollowers->id)
                                                                <a class="btn color-1 size-2 hover-1 follow {{ $user->checkIsFollowed($following->userFollowers->id)?'unfollow':'isfollowing' }}" data-id="{{ $following->userFollowers->id }}"><span>{{ $user->checkIsFollowed($following->userFollowers->id)?'UNFOLLOW':'FOLLOW' }}   </span></a>
                                                            @endif
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
            </div>
        </div>
    </div>
    @includeWhen(Auth::check(),'_partials.send_message')
@endsection


@push('after-js')
    <script src="{{ asset('home/script/magnific.js') }}"></script>
    <script>
        $(document).ready(function(){

//             Follower Functionlity
                    $('.follow').click(function(e){
                        e.preventDefault();
                        var $self = $(this);
                        $.ajax({
                            url:'{!!  route('user.follow') !!}',
                            type:'POST',
                            data:
                                {
                                    follower_id:$(this).data('id'),
                                    _token:'{!! csrf_token() !!} '
                                },
                            success:function()
                            {
                                if($self.hasClass('unfollow')){
                                    $self.removeClass('unfollow');
                                    $self.find('span').text('FOLLOW');
                                }else{
                                    $self.addClass('unfollow');
                                    $self.find('span').text('UNFOLLOW');
                                }
                            },
                            error:function(res)
                            {

                            }
                        })
                    });

//            End Follower functionlity


//            Image Like Functionlity

                    var loading = false;
                    $(document).on('click','.like-image',function(){
                        if(loading){
                            return false;
                        }
                        loading = true;
                        var data_image_id = $(this).data('id');
                        var $self = $(this);
                        $.ajax({
                            url:'{!!  route('user.like.image') !!}',
                            type:'POST',
                            data:
                                {
                                    image_id:data_image_id,
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
                                loading = false;
                            },
                            error:function(res)
                            {

                            }
                        })
                    });

//            Video  Like Functionlity

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



            @if(Auth::user()->id == $user->id)

//              Video Upload Functionlity


                var videos = [];
                var videoTypes = ['mp4','flv','MP2T','3gpp','wmv'];
                var action_block_clone_video;
                var $save_all_block = $('.save-all-video-block');
                var $video_section = $('.videos-section');

                $(document).on('change','#add-video',function(){
                    $('.video-error').hide();
                    if(videos.length > 0){
                        $save_all_block.fadeIn(500);
                    }
                    validateVideo(this,$(this));
                });

                function validateVideo(input,element){
                    if (input.files && input.files[0]) {
                        var extension = input.files[0].name.split('.').pop().toLowerCase(),  //file extension from input file
                            isSuccess = videoTypes.indexOf(extension) > -1;  //is extension in acceptable types.

                        if(input.files[0].size > 33554432){
                            $('.video-error').attr('data-title','Files must be less than 32 MB').addClass('after-show').show();

                            setTimeout(function(){
                                $('.video-error').removeClass('after-show');
                            },1000);

                            return  false;
                        }

                        if(isSuccess)
                        {

                            videos.push(element);
                            var no_video_clone = $('.no-video').clone();
                            var id = $video_section.find('.cancel-added-post').first().data('id');

                            id = id===undefined?0:parseInt(id)+1;

                            $('.add-block-video').html("<a href=\"#\" class=\"be-img-block\">\n" +
                                "                                                <img src=\"{{ asset('default_images/Video-Icon-crop.png') }}\" alt=\"omg\">\n" +
                                "                                            </a>\n <div class='not-saved'>Please Save <i class=\"fa fa-hand-o-down\" aria-hidden=\"true\"></i></div>" +
                                "                                            <div class=\"author-post\">\n" +
                                "                                                <img src=\"{{ Auth::user()->user_profile_image_small }}\" alt=\"\" class=\"ava-author\">\n" +
                                "                                                <span>by <a href=\"page1.html\">{{ Auth::user()->full_name }}</a></span>\n" +
                                "                                            </div>\n" +
                                "                                            <div class=\"info-block\">\n" +
                                "                                                <span><i class=\"fa fa-thumbs-o-up\"></i> 0</span>\n" +
                                "                                                <span><i class=\"fa fa-eye\"></i> 0</span>\n" +
                                "                                            </div>\n" +
                                "                                            <div class=\"action-block\">\n" +
                                "                                                <span data-id='"+id+"' class='save-added-post-video'><i class=\"fa fa-check\"></i>Save</span>\n" +
                                "                                                <span data-id='"+id+"' class='cancel-added-post-video'><i class=\"fa fa-times\"></i>Cancel</span>\n" +
                                "                                            </div>");

                            $('.add-block-video').parent().removeClass('no-video').addClass('video-post no-saved-post').find('.add-block-video').removeClass('add-block-video');
                            $video_section.prepend(no_video_clone);
                            
                            $('#add-video').val('');

                        }else {
                            $('.video-error').attr('data-title','The file must be a file of type: mp4, flv, MP2T, 3gpp, wmv').addClass('after-show').show();

                            setTimeout(function(){
                                $('.video-error').removeClass('after-show');
                            },1000);
                        }
                    }
                }

                $('.save-all-video-click').click(function(){
                    $(this).fadeOut(500);
                    if(videos.length === 0){
                        return false;
                    }
                    upload_video(videos);
                });

                var video_uploading = false;

                $(document).on('click','.save-added-post-video',function(){
                    if(!video_uploading)
                    {
                        video_uploading = true;
                        var data_id = $(this).data('id');
                        var self = $(this);
                        if(!videos[data_id]){
                            return false;
                        }
                        var parent = self.closest('.no-saved-post');
                        upload_video([videos[data_id]],parent,data_id)
                    }
                });


                var upload_video = function($files,parent,data_id){
                    var files_length = $files.length;
                    var form_data = new FormData();
                    for(var i=0;i<files_length;i++){
                        var file_data = $files[i].prop('files')[0];
                        form_data.append('files[]', file_data);
                    }
                    var upload_video_data = $.ajax({
                        url: '{{ route('upload.videos') }}',
                        dataType: 'text',
                        cache: false,
                        headers: {
                            'X-CSRF-Token': '{{ csrf_token() }}'
                        },
                        contentType: false,
                        processData: false,
                        data: form_data,
                        type: 'post',
                        beforeSend:function(){
                            $('#video-block .no-saved-post').css('opacity','0.6');
                        },
                        success: function(){
                            videos.splice(data_id,1);
                            $('#video-block .no-saved-post').removeAttr('style');
                            if(parent)
                            {
                                parent.find('.not-saved').remove();
                                parent.find('.action-block').remove();
                                parent.removeClass('no-saved-post');
                            }else{
                                $video_section.find('.no-saved-post').removeClass('no-saved-post').find('.not-saved, .action-block').remove();
                                videos = [];
                            }
                            video_uploading = false;
                            return true;
                        },
                        error:function(res){
                            var error = JSON.parse(res.responseText);
                            $('.video-error').attr('data-title',error.files[0]).addClass('after-show').show();

                            setTimeout(function(){
                                $('.video-error').removeClass('after-show');
                            },1000);
                        }
                    });

                    return upload_video_data;
                };


                $(document).on('click','.cancel-added-post-video',function(){
                    $(this).closest('.no-saved-post').fadeOut(300,function(){
                        videos.splice($(this).data('id'),1);
                        if(videos.length < 2){
                            $save_all_block.fadeOut(500);
                        }
                        $(this).remove();
                    });
                });


                $(document).on('click','.yes-delete-video',function(){
                    var self  = $(this);
                    var data_video_id  = $(this).data('id');
                    $.ajax({
                        url:'{!!  route('user.video.delete') !!}',
                        type:'POST',
                        data:
                            {
                                video_id:data_video_id,
                                _token:'{!! csrf_token() !!} '
                            },
                        success:function()
                        {
                            self.closest('.video-post').fadeOut(500,function(){
                                $(this).remove();
                            })
                        },
                        error:function(res)
                        {

                        }
                    })
                });


                $(document).on('click','.no-delete-video',function(){
                    $(this).closest('.action-block').html(action_block_clone_video);
                });

                $(document).on('click','.delete-video',function(){
                    action_block_clone_video = $(this).closest('.action-block').html();
                    var video_id = $(this).data('id');
                    $(this).closest('.action-block').html("<span class='no-delete-video'><i class='fa fa-times'></i>No</span>\n" +
                        "                    <span data-id='"+video_id+"'  class='yes-delete-video'><i class='fa fa-check'></i>Yes</span>                ")
                });

                var fileTypesThumbnail = ['jpg', 'png','gif'];  //acceptable file types

                function readURLThumbnail(input,img) {

                    if (input.files && input.files[0]) {
                        var reader = new FileReader();
                        var extension = input.files[0].name.split('.').pop().toLowerCase(),  //file extension from input file
                            isSuccess = fileTypesThumbnail.indexOf(extension) > -1;  //is extension in acceptable types

                        if(input.files[0].size > 8388608){
                            $('.video-error').attr('data-title','Files must be less than 8 MB').addClass('after-show').show();

                            setTimeout(function(){
                                $('.video-error').removeClass('after-show');
                            },1000);

                            return  false;
                        }

                        reader.onload = function (e) {
                            $(img).attr('src', e.target.result);
                        };

                        if(isSuccess){
                            var form_data = new FormData();
                            form_data.append('file', input.files[0]);
                            $.ajax({
                                url: '{{ url('upload-thumbnail') }}'+'/'+ $(img).attr('data-id'),
                                dataType: 'text',
                                cache: false,
                                headers: {
                                    'X-CSRF-Token': '{{ csrf_token() }}'
                                },
                                contentType: false,
                                processData: false,
                                data: form_data,
                                type: 'post',
                                success:function(){

                                },
                                error:function(){
                                    $('.video-error').attr('data-title','Not Saved').addClass('after-show').show();
                                    setTimeout(function(){
                                        $('.video-error').removeClass('after-show');
                                    },1000);
                                }
                            });
                            reader.readAsDataURL(input.files[0]);
                        }else {

                            $('.video-error').attr('data-title','The file must be a file of type: bmp, png, jpg.').addClass('after-show').show();

                            setTimeout(function(){
                                $('.video-error').removeClass('after-show');
                            },1000);
                        }
                    }
                }

                $('.thumbnail').change(function(){
                    $('.file-error').hide();
                    readURLThumbnail(this,$(this).closest('.video-post').find('.be-img-block img'));
                });

//            Image Upload Functionlity

                    var files = [];
                    var fileTypes = ['jpg', 'png','gif'];  //acceptable file types
                    var action_block_clone;

                    $(document).on('change','.add-photo',function(){
                        $('.file-error').hide();
                        if(files.length > 0){
                            $('.save-all-photo-block').fadeIn(500);
                        }
                        readURL(this,$(this));
                    });

                    function readURL(input,element) {
                        if (input.files && input.files[0]) {
                            var extension = input.files[0].name.split('.').pop().toLowerCase(),  //file extension from input file
                                isSuccess = fileTypes.indexOf(extension) > -1;  //is extension in acceptable types
                            if(input.files[0].size > 8388608){
                                $('.file-error').attr('data-title','Files must be less than 8 MB').addClass('after-show').show();

                                setTimeout(function(){
                                    $('.file-error').removeClass('after-show');
                                },1000);

                                return  false;
                            }
                            if (isSuccess) { //yes
                                var reader = new FileReader();
                                files.push(element);
                                reader.onload = function (e) {
                                    var no_photo_clone = $('.no-photo').clone();
                                    var id = $('.photos-section').find('.cancel-added-post').first().data('id');
                                    id = id===undefined?0:parseInt(id)+1;

                                    $('.add-block-photo').html("<a href=\"#\" class=\"be-img-block\">\n" +
                                        "                                                <img src=\""+e.target.result+"\" alt=\"omg\">\n" +
                                        "                                            </a>\n <div class='not-saved'>Please Save <i class=\"fa fa-hand-o-down\" aria-hidden=\"true\"></i></div>" +
                                        "                                            <div class=\"author-post\">\n" +
                                        "                                                <img src=\"{{ Auth::user()->user_profile_image_small }}\" alt=\"\" class=\"ava-author\">\n" +
                                        "                                                <span>by <a href=\"page1.html\">{{ Auth::user()->full_name }}</a></span>\n" +
                                        "                                            </div>\n" +
                                        "                                            <div class=\"info-block\">\n" +
                                        "                                                <span><i class=\"fa fa-thumbs-o-up\"></i> 0</span>\n" +
                                        "                                                <span><i class=\"fa fa-eye\"></i> 0</span>\n" +
                                        "                                            </div>\n" +
                                        "                                            <div class=\"action-block\">\n" +
                                        "                                                <span data-id='"+id+"' class='save-added-post'><i class=\"fa fa-check\"></i>Save</span>\n" +
                                        "                                                <span data-id='"+id+"' class='cancel-added-post'><i class=\"fa fa-times\"></i>Cancel</span>\n" +
                                        "                                            </div>");

                                    $('.add-block-photo').parent().removeClass('no-photo').addClass('photo-post no-saved-post').find('.add-block-photo').removeClass('add-block-photo');
                                    $('.photos-section').prepend(no_photo_clone);
                                    $('.add-photo').val('');
                                }

                                reader.readAsDataURL(input.files[0]);
                            }
                            else {
                                $('.file-error').attr('data-title','The file must be a file of type: bmp, png, jpg.').addClass('after-show').show();

                                setTimeout(function(){
                                    $('.file-error').removeClass('after-show');
                                },1000);
                            }
                        }
                    }


                    $('.save-all-photo-click').click(function(){
                        $(this).fadeOut(500);
                        if(files.length === 0){
                            return false;
                        }
                        upload_images(files);
                    });



                    $(document).on('click','.save-added-post',function(){
                        var data_id = $(this).data('id');
                        var self = $(this);
                        if(!files[data_id]){
                            return false;
                        }
                        var parent = self.closest('.no-saved-post');
                        upload_images([files[data_id]],parent,data_id);
                    });



                    var upload_images = function($files,parent,data_id){
                        var files_length = $files.length;
                        var form_data = new FormData();
                        for(var i=0;i<files_length;i++){
                            var file_data = $files[i].prop('files')[0];
                            form_data.append('files[]', file_data);
                        }
                        var upload = $.ajax({
                            url: '{{ route('upload.images') }}',
                            dataType: 'text',
                            cache: false,
                            headers: {
                                'X-CSRF-Token': '{{ csrf_token() }}'
                            },
                            contentType: false,
                            processData: false,
                            data: form_data,
                            type: 'post',
                            beforeSend:function(){
                              $('#photo-block .no-saved-post').css('opacity','0.6');
                            },
                            success: function(){
                                files.splice(data_id,1);
                                $('.no-saved-post').removeAttr('style');
                                if(parent){
                                    parent.find('.not-saved').remove();
                                    parent.find('.action-block').remove();
                                    parent.removeClass('no-saved-post');
                                }else{
                                    $('.no-saved-post').removeClass('no-saved-post').find('.not-saved,.action-block').remove();
                                    files = [];
                                }
                                return true;
                            },
                            error:function(res){
                                var error = JSON.parse(res.responseText);
                                $('.file-error').attr('data-title',error.files[0]).addClass('after-show').show();

                                setTimeout(function(){
                                    $('.file-error').removeClass('after-show');
                                },1000);
                            }
                        });

                        return upload;
                    };


                    $(document).on('click','.cancel-added-post',function(){
                       $(this).closest('.no-saved-post').fadeOut(300,function(){
                           files.splice($(this).data('id'),1);
                           if(files.length < 2){
                               $('.save-all-photo-block').fadeOut(500);
                           }
                           $(this).remove();
                       });
                    });



                    $(document).on('click','.yes-delete-image',function(){
                        var self  = $(this);
                        var data_image_id  = $(this).data('id');
                        $.ajax({
                            url:'{!!  route('user.image.delete') !!}',
                            type:'POST',
                            data:
                                {
                                    image_id:data_image_id,
                                    _token:'{!! csrf_token() !!} '
                                },
                            success:function()
                            {
                                self.closest('.photo-post').fadeOut(500,function(){
                                    $(this).remove();
                                })
                            },
                            error:function(res)
                            {

                            }
                        })
                    });


                    $(document).on('click','.no-delete-image',function(){
                        $(this).closest('.action-block').html(action_block_clone);
                    });

                    $(document).on('click','.delete-image',function(){
                       action_block_clone = $(this).closest('.action-block').html();
                       var image_id = $(this).data('id');
                        $(this).closest('.action-block').html("<span class='no-delete-image'><i class='fa fa-times'></i>No</span>\n" +
                           "                    <span data-id='"+image_id+"'  class='yes-delete-image'><i class='fa fa-check'></i>Yes</span>                ")
                    });

            @endif


            $('.photo-post').click(function(){
                if({{ $user->id }} != {{ Auth::user()->id }}){
                    $.ajax({
                        url:"{{ route('image.view') }}",
                        method:'POST',
                        data:{
                            _token:'{!! csrf_token() !!}',
                            image_id:$(this).data('id')
                        },
                        success:function(){

                        },
                        error:function(){

                        }
                    })
                }
            });

            $('.video-post').click(function(){
                if({{ $user->id }} != {{ Auth::user()->id }}){
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
                }
            });

            $('.popup-gallery').magnificPopup({
                delegate: 'section',
                type: 'image',
                tLoading: 'Loading image #%curr%...',
                mainClass: 'mfp-img-mobile',
                gallery: {
                    enabled: true,
                    navigateByImgClick: true,
                    preload: [0,1] // Will preload 0 - before current, and 1 after the current image
                },
                image: {
                    tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
                    titleSrc: function(item) {
                        return item.el.attr('title') + '<small>by Marsel Van Oosten</small>';
                    }
                }
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
        })
    </script>
@endpush