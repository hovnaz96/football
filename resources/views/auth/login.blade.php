@extends('layouts.home')

@section('content')
    <div id="login-signup" class="col-xs-12 col-sm-6 col-md-4">
        <p class="text">Login</p>
        <div class="form-group">
            <label for="email">E-mail/Username <span class="error error-username"></span></label>
            <input type="text" id="email" class="form-control"/>
        </div>
        <div class="form-group">
            <label for="password">Password <span class="error error-password"></span></label>
            <input type="password" id="password" class="form-control"/>
        </div>
        <div class="form-group checkbox-group">
            <div class="checkbox">
                <label>
                    <input type="checkbox" id='remember' name="remember"> Remember Me
                </label>
            </div>
        </div>
        <button id="login">Log In</button>
        <a href="">Forgot Your password?</a>
    </div>
@endsection


@push('js')
    <script>
        $(document).ready(function(){
            $('#login').on('click',function(e){
                e.preventDefault();
                $.ajax({
                    url: '{!! route('login') !!}',
                    method:'POST',
                    data:{
                        email:$('#email').val(),
                        password:$('#password').val(),
                        remember:$('#remember').val(),
                        _token: '{!!  csrf_token() !!}'
                    },
                    dataType:'json',
                    success:function(res){
                        window.location.href = res.redirect_path;
                    },
                    error:function(res){
                        var error = res.responseJSON;
                        $('.error').text('');
                        if(error.email){
                            $('.error-username').text(error.email);
                        }
                        if(error.password){
                            $('.error-password').text(error.password);
                        }
                    }
                })
            });
            $('input').keyup(function(event){
                if(event.keyCode === 13){
                    $('#login').trigger('click');
                }
            });
        });
    </script>
@endpush