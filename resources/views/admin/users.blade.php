@extends('layouts.admin')


@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Users Listing
                        <small>view all users in the system</small>
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
                                    <th class="column-title">First Name</th>
                                    <th class="column-title">Last Name</th>
                                    <th class="column-title">Username</th>
                                    <th class="column-title">Email</th>
                                    <th class="column-title">Date of Birth</th>
                                    <th class="column-title">Birth Place</th>
                                    <th class="column-title no-link last"><span class="nobr">Action</span>
                                    </th>
                                    <th class="bulk-actions" colspan="7">
                                        <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span
                                                    class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                                    </th>
                                </tr>
                                </thead>

                                <tbody>
                                    @foreach($users as $user)
                                        <tr class="even pointer">
                                            <td class="a-center ">
                                                <input type="checkbox" class="flat" name="table_records">
                                            </td>
                                            <td class=" user-name">{{ $user->firstname }}</td>
                                            <td class="user-name ">{{ $user->lastname }}</td>
                                            <td class=" user-name">{{ $user->username }}</td>
                                            <td class="user-name ">{{ $user->email }}</td>
                                            <td class=" ">{{ $user->day.'/'.$user->month.'/'.$user->year }}</td>
                                            <td class=" ">{{ $user->birth_place }}</td>
                                            <td class=" last">
                                                <a href="{{ url('superuser/users',['slug'=>$user->slug]) }}">Edit</a>
                                                <span>&nbsp;</span>
                                                <a href="#" data-id='{{ $user->id }}' class="delete-user">Delete</a>
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
            $('.delete-user').click(function(){
                var block = $(this).closest('.pointer');
                $.ajax({
                    url:"{{ url('/superuser/users') }}"+'/'+$(this).attr('data-id'),
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

        })
    </script>

@endpush