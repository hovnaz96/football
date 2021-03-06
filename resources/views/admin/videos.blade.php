@extends('layouts.admin')


@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Image Listing
                        <small>view all users images in the system</small>
                    </h3>
                </div>

                <div class="title_right">
                    <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                        <div class="input-group">
                            <input type="text" class="form-control search-input" placeholder="Search for...">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button">Go!</button>
                    </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_content">
                        <div class="table-responsive">
                            <table class="table table-striped jambo_table bulk_action">
                                <thead>
                                <tr class="headings">
                                    <th>
                                        <input type="checkbox" id="check-all" class="flat">
                                    </th>
                                    <th class="column-title">Thumbnail</th>
                                    <th class="column-title">First Name</th>
                                    <th class="column-title">Last Name</th>
                                    <th class="column-title">Email</th>
                                    <th class="column-title">Likes</th>
                                    <th class="column-title">Views</th>
                                    <th class="column-title no-link last"><span class="nobr">Action</span>
                                    </th>
                                    <th class="bulk-actions" colspan="7">
                                        <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span
                                                    class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                                    </th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($videos as $video)
                                    <tr class="even pointer">
                                        <td class="a-center ">
                                            <input type="checkbox" class="flat" name="table_records">
                                        </td>
                                        <td class=" "><img src="{{ $video->url_video_thumbnail }}" style="width: 35px;height: 35px;object-fit: cover"/></td>
                                        <td class="user-name">{{ $video->user->firstname }}</td>
                                        <td class="user-name">{{ $video->user->lastname }}</td>
                                        <td class=" ">{{ $video->user->email }}</td>
                                        <td class=" ">{{ $video->video_likes_count }}</td>
                                        <td class=" ">{{ $video->views }}</td>
                                        <td class=" last">
                                            <a href="{{ $video->video_url }}"  target="_blank" data-view="{{ $video->video_url }}">View Image</a>
                                            <span>&nbsp;</span>
                                            <a href="#" data-id='{{ $video->id }}' class="delete-video">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script>
        $(document).ready(function(){
            $(document).on('keyup','.search-input',function(){
                var input, filter, ul, li, a, i;
                input = $(this);
                filter = input.val().toUpperCase();
                ul = $('tbody');
                li = ul.find('.pointer');

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

            $('.delete-video').click(function(){
                var block = $(this).closest('.pointer');
                $.ajax({
                    url:"{{ url('/superuser/videos') }}"+'/'+$(this).attr('data-id'),
                    type:'POST',
                    data:{
                        _token:'{!! csrf_token() !!}',
                        _method:'DELETE',
                    },
                    success:function(){
                        block.fadeOut();
                    }
                })
            })
        })
    </script>

@endpush