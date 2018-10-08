@if(Auth::guest())

    <div class="large-popup login" id="login-block">
        <div class="large-popup-fixed"></div>
        <div class="container large-popup-container">
            <div class="row">
                <div class="col-md-8 col-md-push-2 col-lg-6 col-lg-push-3  large-popup-content">
                    <div class="row">
                        <div class="col-md-12">
                            <i class="fa fa-times close-button"></i>
                            <h5 class="large-popup-title">Log in</h5>
                        </div>
                        <form action="./" class="popup-input-search">
                            <div class="col-md-6">
                                <input id='email' class="input-signtype" type="email" required="" placeholder="Your email/username">
                                <i class="fa fa-times error email-error"  title=""></i>
                            </div>
                            <div class="col-md-6">
                                <input id='password' class="input-signtype" type="password" required="" placeholder="Password">
                                <i class="fa fa-times error password-error"  title=""></i>

                            </div>
                            <div class="col-xs-6">
                                <div class="be-checkbox">
                                    <label class="check-box">
                                        <input id='remember' class="checkbox-input" type="checkbox"/> <span class="check-box-sign"></span>
                                    </label>
                                    <span class="large-popup-text">
                                            Stay signed in
                                        </span>
                                </div>
                                {{--<a href="blog-detail-2.html" class="link-large-popup">Forgot password?</a>--}}
                            </div>
                            <div class="col-xs-6 for-signin">
                                <input id="login" type="submit" class="be-popup-sign-button" value="SIGN IN">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @push('after-js')
        <script>
            $(document).ready(function(){
                var $parent_login = $('#login-block');
                $('#login').on('click', function (e) {
                    e.preventDefault();
                    $.ajax({
                        url: '{!! route('login') !!}',
                        method: 'POST',
                        data: {
                            email: $parent_login.find('#email').val(),
                            password: $parent_login.find('#password').val(),
                            remember: $parent_login.find('#remember').val(),
                            _token: '{!!  csrf_token() !!}'
                        },
                        dataType: 'json',
                        success: function (res) {
                            window.location.href = res.redirect_path;
                        },
                        error: function (res) {
                            var error = res.responseJSON;
                            $parent_login.find('.error').hide();
                            if (error.email) {
                                $parent_login.find('.email-error').show().attr('data-title',error.email).addClass('after-show');
                            }
                            if (error.password) {
                                $parent_login.find('.password-error').show().attr('data-title',error.password).addClass('after-show');
                            }

                            setTimeout(function(){
                                $parent_login.find('.error').removeClass('after-show');
                            },1000);
                        }
                    })
                });

                $parent_login.find('input').keyup(function (event) {
                    if (event.keyCode === 13) {
                        $('#login').trigger('click');
                    }
                });
            })
        </script>
    @endpush
@endif