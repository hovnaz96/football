@extends('layouts.home')

@section('content')
    <div id="login-signup" class="col-xs-12 col-sm-10 col-md-6">
        <p class="text">Sign Up</p>
        <div class="row">
            <div class="form-group col-sm-6">
                <label for="firstname">First Name <span class="error error-firstname"></span></label>
                <input type="text" id="first_name" class="form-control" placeholder="First Name"/>
            </div>
            <div class="form-group col-sm-6">
                <label for="lastname">Last Name <span class="error error-lastname"></span></label>
                <input type="text" id="last_name" class="form-control" placeholder="Last Name"/>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-6">
                <label for="username">Username <span class="error error-username"></span></label>
                <input class="form-control" placeholder="Username"  type="text" id="username"/>
            </div>
            <div class="form-group col-sm-6">
                <label for="email">E-mail <span class="error error-email"></span></label>
                <input class="form-control" placeholder="E-mail" type="text" id="email"/>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-6">
                <label for="password">Password <span class="error error-password"></span></label>
                <input class="form-control" type="password" placeholder="Password"  id="password"/>
            </div>
            <div class="form-group col-sm-6">
                <label for="confirm_password">Re-Password</label>
                <input class="form-control" type="password" id="confirm_password" placeholder="Re-password" />
            </div>
        </div>

        <button id="signup">Sign Up</button>
        <a href="{{ url('/login') }}">You have a account?</a>
    </div>
@endsection


@push('js')
    <script>
        $(document).ready(function() {
            $('#signup').on('click',function(e){
                e.preventDefault();
                $.ajax({
                    url: '{!! route('register') !!}',
                    method:'POST',
                    data:{
                        firstname:$('#first_name').val(),
                        lastname:$('#last_name').val(),
                        username:$('#username').val(),
                        email:$('#email').val(),
                        password:$('#password').val(),
                        password_confirmation:$('#confirm_password').val(),
                        _token: '{!!  csrf_token() !!}'
                    },
                    dataType:'json',
                    success:function(res){
                        window.location.href = res.redirect_path;
                    },
                    error:function(res){
                        $('.error').text('');
                        var error = res.responseJSON;
                        if(error.firstname){
                            $('.error-firstname').text(error.firstname[0]);
                        }
                        if(error.lastname){
                            $('.error-lastname').text(error.lastname[0]);
                        }
                        if(error.username){
                            $('.error-username').text(error.username[0]);
                        }
                        if(error.email){
                            $('.error-email').text(error.email[0]);
                        }
                        if(error.password){
                            $('.error-password').text(error.password[0]);
                        }
                    }
                })
            });
            $('input').keyup(function(event){
                if(event.keyCode === 13){
                    $('#signup').trigger('click');
                }
            });
        });
    </script>
@endpush