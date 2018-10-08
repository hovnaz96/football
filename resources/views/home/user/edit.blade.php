@extends('layouts.home')

@section('content')
    <div id="content-block">
        <div class="container be-detail-container">
            <div class="row">
                <div class="col-xs-12 col-md-3 left-feild">
                    <div class="be-vidget back-block">
                        <a class="btn full color-1 size-1 hover-1" href="{{ url('user-profile/'.$user->slug)  }}"><i class="fa fa-chevron-left"></i>back
                            to profile</a>
                    </div>
                    <div class="be-vidget hidden-xs hidden-sm" id="scrollspy">
                        <h3 class="letf-menu-article">
                            Choose Category
                        </h3>
                        <div class="creative_filds_block">
                            <ul class="ul nav">
                                <li class="edit-ln"><a href="#basic-information">Basic Information</a></li>
                                <li class="edit-ln"><a href="#edit-password">Edit Password</a></li>
                                <li class="edit-ln"><a href="#on-the-web">On The Web</a></li>
                                <li class="edit-ln"><a href="#about-me">About Me</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-9 _editor-content_">
                    <div class="sec" data-sec="basic-information" id="basic-information">
                        <form>
                            <div class="be-large-post">
                                <div class="info-block style-2">
                                    <div class="be-large-post-align "><h3 class="info-block-label">Basic Information</h3></div>
                                </div>
                                <div class="be-large-post-align">
                                    <div class="be-change-ava">
                                        <label  for="upload-profile" class="be-ava-user style-2 cursor-pointer">
                                            <img id='user-image' src="{{ $user->user_profile_image_large }}" title='{{ $user->full_name }}' alt="{{  $user->full_name }}" >
                                        </label>
                                        <label for='upload-profile' class="btn color-4 size-2 hover-7">
                                            replace image
                                            <i class="fa fa-times error file-error"  title=""></i>
                                        </label>
                                        <i class="fa fa-rotate-left undo-image"  title=""></i>

                                        <input name="profile"  accept="image/x-png,image/gif,image/jpeg" type="file" class="hidden" id="upload-profile">
                                    </div>
                                </div>
                                <div class="be-large-post-align">
                                    <div class="row">
                                        <div class="input-col col-xs-12 col-sm-6">
                                            <div class="form-group fg_icon focus-2">
                                                <div class="form-label">First Name</div>
                                                <input id='firstname' class="form-input" type="text" value="{{ $user->firstname }}">
                                                <i class="fa fa-times error firstname-error"  title=""></i>
                                            </div>
                                        </div>
                                        <div class="input-col col-xs-12 col-sm-6">
                                            <div class="form-group focus-2">
                                                <div class="form-label">Last Name</div>
                                                <input id='lastname' class="form-input" type="text" value="{{ $user->lastname }}">
                                                <i class="fa fa-times error lastname-error"  title=""></i>
                                            </div>
                                        </div>
                                        <div class="input-col col-xs-12">
                                            <div class="form-group focus-2">
                                                <div class="form-label">Occupation</div>
                                                <input id='occupation' class="form-input" type="text" value="{{ $user->personal_info->occupation }}">
                                                <i class="fa fa-times error occupation-error"  title=""></i>
                                            </div>
                                        </div>
                                        <div class="input-col col-xs-12 col-sm-6  form-group focus-2 ">
                                            <div class="form-label">Country</div>
                                            <div class="be-custom-select-block">
                                                <i class="fa fa-times error country-error"  title=""></i>
                                                <select id='country' class="be-custom-select form-input outline-none">
                                                    @foreach($countries as $country)
                                                        <option {{ $country->id==$user->personal_info->country_id?'selected':'' }} value="{{ $country->id }} ">{{ $country->citizenship }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="input-col col-xs-12 col-sm-6">
                                            <div class="form-group focus-2">
                                                <div class="form-label">City</div>
                                                <input id='city' class="form-input" type="text" value="{{ $user->personal_info->city }}">
                                                <i class="fa fa-times error city-error"  title=""></i>
                                            </div>
                                        </div>
                                        <div class="input-col col-xs-12 col-sm-12  form-group focus-2 ">
                                            <div class="form-label">
                                                Date of Birth
                                                <i class="fa fa-times error date-of-birth-error"  title=""></i>
                                            </div>
                                            <div class="be-custom-select-block col-xs-12 col-sm-4 padding-0">
                                                <select class="be-custom-select  form-input outline-none" id="years">
                                                    <option value="" disabled selected>
                                                        Year
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="be-custom-select-block mounth col-xs-12 col-sm-4 padding-0-15">
                                                <select class="be-custom-select  form-input outline-none" id="months">
                                                    <option value="" disabled selected>
                                                        Month
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="be-custom-select-block col-xs-12 col-sm-4 padding-0-15">
                                                <select class="be-custom-select  form-input outline-none"  id="days">
                                                    <option value="" disabled selected>
                                                        Day
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-4 pull-right">
                                            <a id='save_basic_info' class="btn color-1 size-2 hover-1 btn-right">Save Changes</a>
                                            <i class="fa fa-check success pull-right"  title=""></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="sec" data-sec="edit-password"  id="update-password">
                        <form>
                            <div class="be-large-post">
                                <div class="info-block style-2">
                                    <div class="be-large-post-align"><h3 class="info-block-label">Password</h3></div>
                                </div>
                                <div class="be-large-post-align">
                                    <div class="row">
                                        <div class="input-col col-xs-12 col-sm-4">
                                            <div class="form-group focus-2">
                                                <div class="form-label">Old Password</div>
                                                <input id='old_password' class="form-input" type="password" placeholder="">
                                                <i class="fa fa-times error old_password-error"  title=""></i>
                                            </div>
                                        </div>
                                        <div class="input-col col-xs-12 col-sm-4">
                                            <div class="form-group focus-2">
                                                <div class="form-label">New Password</div>
                                                <input id='password' class="form-input" type="password" placeholder="">
                                                <i class="fa fa-times error password-error"  title=""></i>
                                            </div>
                                        </div>
                                        <div class="input-col col-xs-12 col-sm-4">
                                            <div class="form-group focus-2">
                                                <div class="form-label">Repeat Password</div>
                                                <input id='confirm' class="form-input" type="password" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-4 pull-right">
                                            <a id='update_password'  class="btn color-1 size-2 hover-1 btn-right">change password</a>
                                            <i class="fa fa-check success pull-right"  title=""></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="sec" data-sec="on-the-web" id="social-links">
                        <div class="be-large-post m-social">
                            <div class="info-block style-2">
                                <div class="be-large-post-align"><h3 class="info-block-label">On The Web</h3></div>
                            </div>
                            <form>
                                <div class="be-large-post-align">
                                    <div class="social-input form-group focus-2">
                                        <div class="s_icon">
                                            <div class="social-bars"><i class="fa fa-bars"></i></div>
                                            <a target='_blank' class="social-btn color-1" href="{{ $user->personal_info->facebook }}"><i
                                                        class="fa fa-facebook"></i></a>
                                        </div>
                                        <div class="s_input">
                                            <input id='facebook' class="form-input" type="text" value="{{ $user->personal_info->facebook }}">
                                            <i class="fa fa-times error facebook-error"  title=""></i>
                                        </div>
                                    </div>
                                    <div class="social-input form-group focus-2">
                                        <div class="s_icon">
                                            <div class="social-bars"><i class="fa fa-bars"></i></div>
                                            <a target='_blank' class="social-btn color-2" href="{{ $user->personal_info->twitter }}"><i
                                                        class="fa fa-twitter"></i></a>
                                        </div>
                                        <div class="s_input">
                                            <input id='twitter' class="form-input" type="text" value="{{ $user->personal_info->twitter }}">
                                            <i class="fa fa-times error twitter-error"  title=""></i>
                                        </div>
                                    </div>
                                    <div class="social-input form-group focus-2">
                                        <div class="s_icon">
                                            <div class="social-bars"><i class="fa fa-bars"></i></div>
                                            <a target='_blank' class="social-btn color-3" href="{{ $user->personal_info->google_plus }}"><i
                                                        class="fa fa-google-plus"></i></a>
                                        </div>
                                        <div class="s_input">
                                            <input id='google_plus'  class="form-input" type="text" value="{{ $user->personal_info->google_plus }}">
                                            <i class="fa fa-times error google_plus-error"  title=""></i>
                                        </div>
                                    </div>
                                    <div class="social-input form-group focus-2">
                                        <div class="s_icon">
                                            <div class="social-bars"><i class="fa fa-bars"></i></div>
                                            <a target='_blank' class="social-btn color-5" href="{{ $user->personal_info->instagram }}"><i
                                                        class="fa fa-instagram"></i></a>
                                        </div>
                                        <div class="s_input">
                                            <input id='instagram' class="form-input" type="text" value="{{ $user->personal_info->instagram }}">
                                            <i class="fa fa-times error instagram-error"  title=""></i>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-4 pull-right">
                                            <a id='social_links' class="btn color-1 size-2 hover-1 btn-right">Save Changes</a>
                                            <i class="fa fa-check success pull-right"  title=""></i>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="sec" data-sec="about-me" id="about-me">
                        <form>
                            <div class="be-large-post">
                                <div class="info-block style-2">
                                    <div class="be-large-post-align"><h3 class="info-block-label">About Me</h3></div>
                                </div>
                                <div class="be-large-post-align">
                                    <div class="row">
                                        <div class="input-col col-xs-12">
                                            <div class="form-group focus-2">
                                                <div class="form-label">Description</div>
                                                <textarea id='description' class="form-input" required=""
                                                          placeholder="Something about you">{{ !is_null($user->personal_info->description)?$user->personal_info->description:'' }}</textarea>
                                                <i class="fa fa-times error description-error"  title=""></i>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-4 pull-right">
                                            <a id='about_me' class="btn color-1 size-2 hover-1 btn-right">Save Changes</a>
                                            <i class="fa fa-check success pull-right"  title=""></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



@push('after-js')
    <script>
        $(document).ready(function(){

            var fileTypes = ['jpg', 'jpeg', 'png','gif'];  //acceptable file types

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var extension = input.files[0].name.split('.').pop().toLowerCase(),  //file extension from input file
                        isSuccess = fileTypes.indexOf(extension) > -1;  //is extension in acceptable types

                    if (isSuccess) { //yes
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            $('#user-image').attr('src', e.target.result);
                        }

                        reader.readAsDataURL(input.files[0]);
                    }
                    else {
                        $('.file-error').attr('data-title','The file must be a file of type: jpeg, bmp, png, jpg.').addClass('after-show').show();

                        setTimeout(function(){
                            $('.file-error').removeClass('after-show');
                        },1000);
                    }
                }
            }


            $("#upload-profile").change(function(){
                readURL(this);
                $('.undo-image').show();
            });

            $('.undo-image').click(function(){
                $("#upload-profile").val('');
                $('#user-image').attr('src', '{{ $user->user_profile_image_large }}');
                $('.file-error').attr('data-title','').removeClass('after-show').hide();
                $(this).hide();
            });


            var check_error = function($array,$data,$parent){
                if($data){
                    $array.forEach(function(value){
                        if ($data[value]) {
                            $parent.find('.'+value+'-error').show().attr('data-title',$data[value][0]).addClass('after-show');
                        }
                    });
                    setTimeout(function(){
                        $parent.find('.error').removeClass('after-show');
                    },1000);
                }
            };

            var upload_image = function($file){
                var file_data = $file.prop('files')[0];
                var form_data = new FormData();
                form_data.append('file', file_data);
                $.ajax({
                    url: '{{ route('upload.image.profile') }}',
                    dataType: 'text',
                    cache: false,
                    headers: {
                        'X-CSRF-Token': '{{ csrf_token() }}'
                    },
                    contentType: false,
                    processData: false,
                    data: form_data,
                    type: 'post',
                    success: function(){
                        return true;
                    },
                    error:function(res){
                        var $parent =  $('#basic-information');
                        console.log(res);
                        check_error(['file'],JSON.parse(res.responseText),$parent);
                    }
                });
            };


            $('#save_basic_info').click(function(){
               var $parent =  $('#basic-information');
               $parent.find('.success').hide(300);
               $parent.find('.error').hide();

               if(upload_image($('#upload-profile'))){
                    $('.undo-image').hide();
               }

               $.ajax({
                   url:'{!!  route('user.update.basic_info') !!}',
                   method:'POST',
                   data:
                   {
                       firstname:$parent.find('#firstname').val(),
                       lastname:$parent.find('#lastname').val(),
                       occupation:$parent.find('#occupation').val(),
                       country_id:$parent.find('#country').val(),
                       city:$parent.find('#city').val(),
                       month: $parent.find('#months').val(),
                       year: $parent.find('#years').val(),
                       day: $parent.find('#days').val(),
                       _token:'{!! csrf_token() !!} '
                   },
                   success:function()
                   {
                       $parent.find('.success').show(300);
                       $('.undo-image').hide();
                   },
                   error:function(res)
                   {
                       var error = res.responseJSON;
                       check_error(['firstname','lastname','occupation','country_id','city'],error,$parent);
                       if(error){
                           if (error.year || error.data_of_birth) {
                               var date = error.year?error.year[0]:error.data_of_birth[0];
                               $parent.find('.date-of-birth-error').show().attr('data-title',date).addClass('after-show');
                           }
                       }
                   }
               })
            });


            $('#update_password').click(function(){
                var $parent =  $('#update-password');
                $parent.find('.success').hide(300);
                $parent.find('.error').hide();
                $.ajax({
                    url:'{!!  route('user.update.password') !!}',
                    method:'POST',
                    data:
                        {
                            old_password:$parent.find('#old_password').val(),
                            password:$parent.find('#password').val(),
                            password_confirmation:$parent.find('#confirm').val(),
                            _token:'{!! csrf_token() !!} '
                        },
                    success:function()
                    {
                        $parent.find('.success').show(300);
                        $parent.find('input').val('');
                    },
                    error:function(res)
                    {
                        check_error(['password','old_password'],res.responseJSON,$parent);

                    }
                })
            });


            $('#social_links').click(function(){
                var $parent =  $('#social-links');
                $parent.find('.success').hide(300);
                $parent.find('.error').hide();
                $.ajax({
                    url:'{!!  route('user.update.social_links') !!}',
                    method:'POST',
                    data:
                        {
                            facebook:$parent.find('#facebook').val(),
                            twitter:$parent.find('#twitter').val(),
                            google_plus:$parent.find('#google_plus').val(),
                            instagram:$parent.find('#instagram').val(),
                            _token:'{!! csrf_token() !!} '
                        },
                    success:function()
                    {
                        $parent.find('.success').show(300);
                    },
                    error:function(res)
                    {
                        check_error(['facebook','twitter','google_plus','instagram'],res.responseJSON,$parent);
                    }
                })
            });



            $('#about_me').click(function(){
                var $parent =  $('#about-me');
                $parent.find('.success').hide(300);
                $parent.find('.error').hide();
                $.ajax({
                    url:'{!!  route('user.update.description') !!}',
                    method:'POST',
                    data:
                    {
                        description:$parent.find('#description').val(),
                        _token:'{!! csrf_token() !!} '
                    },
                    success:function()
                    {
                        $parent.find('.success').show(300);
                    },
                    error:function(res)
                    {
                        check_error(['description'],res.responseJSON,$parent);
                    }
                })
            });

            $(function() {
                var $years = $('#years');
                var $months = $('#months');
                var $year_month = $('#years, #months');
                //populate our years select box
                for (i = new Date().getFullYear(); i > 1900; i--){
                    if(i == '{{ $user->year }}'){
                        $years.append($('<option selected />').val(i).html(i));
                        continue;
                    }
                    $years.append($('<option />').val(i).html(i));
                }
                var months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
                //populate our months select box
                for (i = 1; i < 13; i++){
                    if(i == '{{ $user->month }}'){
                        $months.append($('<option selected />').val(i).html(months[i-1]));
                        $year_month.trigger('change');
                        continue;
                    }
                    $months.append($('<option />').val(i).html(months[i-1]));
                }
                //populate our Days select box
                updateNumberOfDays();

                //"listen" for change events
                $year_month.change(function(){
                    updateNumberOfDays();
                });

            });

            function updateNumberOfDays(){
                var $days = $('#days');
                var $years = $('#years');
                var $months = $('#months');
                $days.html('<option value="" disabled selected>Day</option>');
                var month = $months.val();
                var year = $years.val();
                days = daysInMonth(month, year);

                for(var i=1; i < days+1 ; i++){
                    if(i == '{{ $user->day }}'){
                        $days.append($('<option selected />').val(i).html(i));
                        continue;
                    }
                    $days.append($('<option />').val(i).html(i));
                }
            }

            function daysInMonth(month, year) {
                return new Date(year, month, 0).getDate();
            }

        })
    </script>

@endpush