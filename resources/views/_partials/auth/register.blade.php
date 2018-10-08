@if(Auth::guest())

    <div class="large-popup register" id="signup-block">
        <div class="large-popup-fixed"></div>
        <div class="container large-popup-container">
            <div class="row">
                <div class="col-md-10 col-md-push-1 col-lg-8 col-lg-push-2 large-popup-content">
                    <div class="row">
                        <div class="col-md-12">
                            <i class="fa fa-times close-button"></i>
                            <h5 class="large-popup-title">Register</h5>
                        </div>
                        <form action="./" class="popup-input-search">
                            <div class="col-md-6">
                                <input id='first_name' class="input-signtype" type="text" required="" placeholder="First Name">
                                <i class="fa fa-times error first_name-error"  title=""></i>
                            </div>
                            <div class="col-md-6">
                                <input id='last_name' class="input-signtype" type="text" required="" placeholder="Last Name">
                                <i class="fa fa-times error last_name-error"  title=""></i>
                            </div>
                            <div class="col-md-6">
                                <input id='username'  class="input-signtype" type="text" required="" placeholder="Username">
                                <i class="fa fa-times error username-error"  title=""></i>
                            </div>
                            <div class="col-md-6">
                                <input id='email' class="input-signtype" type="text" required="" placeholder="Email">
                                <i class="fa fa-times error email-error"  title=""></i>
                            </div>
                            <div class="col-md-6">
                                <input id='password' class="input-signtype" type="password" required="" placeholder="Password">
                                <i class="fa fa-times error password-error"  title=""></i>
                            </div>
                            <div class="col-md-6">
                                <input id='confirm_password' class="input-signtype" type="password" required="" placeholder="Repeat Password">
                            </div>
                            <div class="col-md-12 be-date-block">
                                <span class="large-popup-text">
                                Date of birth
                                     <i class="fa fa-times error date-error"  title=""></i>
                                </span>
                                <div class="be-custom-select-block">
                                    <select class="be-custom-select" id="years">
                                        <option value="" disabled selected>
                                            Year
                                        </option>
                                    </select>
                                </div>
                                <div class="be-custom-select-block mounth">
                                    <select class="be-custom-select" id="months">
                                        <option value="" disabled selected>
                                            Month
                                        </option>
                                    </select>
                                </div>
                                <div class="be-custom-select-block">
                                    <select class="be-custom-select"  id="days">
                                        <option value="" disabled selected>
                                            Day
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 pull-right for-signin">
                                <input id='signup' type="submit" class="be-popup-sign-button" value="SIGN UP">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('after-js')
    <script>
        $(document).ready(function () {

            $(function() {

                //populate our years select box
                for (i = new Date().getFullYear(); i > 1900; i--){
                    $('#years').append($('<option />').val(i).html(i));
                }
                var months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
                //populate our months select box
                for (i = 1; i < 13; i++){

                    $('#months').append($('<option />').val(i).html(months[i-1]));
                }
                //populate our Days select box
                updateNumberOfDays();

                //"listen" for change events
                $('#years, #months').change(function(){
                    updateNumberOfDays();
                });

            });

            function updateNumberOfDays(){
                $('#days').html('<option value="" disabled selected>Day</option>');
                month = $('#months').val();
                year = $('#years').val();
                days = daysInMonth(month, year);

                for(i=1; i < days+1 ; i++){
                    $('#days').append($('<option />').val(i).html(i));
                }
            }

            function daysInMonth(month, year) {
                return new Date(year, month, 0).getDate();
            }

            var $parent_signup  = $('#signup-block');

            $('#signup').on('click', function (e) {
                e.preventDefault();
                $.ajax({
                    url: '{!! route('register') !!}',
                    method: 'POST',
                    data: {
                        firstname: $parent_signup.find('#first_name').val(),
                        lastname: $parent_signup.find('#last_name').val(),
                        username: $parent_signup.find('#username').val(),
                        email: $parent_signup.find('#email').val(),
                        month: $parent_signup.find('#months').val(),
                        year: $parent_signup.find('#years').val(),
                        day: $parent_signup.find('#days').val(),
                        password: $parent_signup.find('#password').val(),
                        password_confirmation: $parent_signup.find('#confirm_password').val(),
                        _token: '{!!  csrf_token() !!}'
                    },
                    dataType: 'json',
                    success: function (res) {
                        window.location.href = res.redirect_path;
                    },
                    error: function (res) {
                        var error = res.responseJSON;
                        $parent_signup.find('.error').hide();
                        if (error.firstname) {
                            $parent_signup.find('.first_name-error').show().attr('data-title',error.firstname[0]).addClass('after-show');
                        }

                        if (error.lastname) {
                            $parent_signup.find('.last_name-error').show().attr('data-title',error.lastname[0]).addClass('after-show');
                        }

                        if (error.username) {
                            $parent_signup.find('.username-error').show().attr('data-title',error.username[0]).addClass('after-show');
                        }

                        if (error.email) {
                            $parent_signup.find('.email-error').show().attr('data-title',error.email[0]).addClass('after-show');
                        }

                        if (error.password) {
                            $parent_signup.find('.password-error').show().attr('data-title',error.password[0]).addClass('after-show');
                        }

                        if (error.year || error.date_of_birth) {
                            var date = error.year?error.year[0]:error.date_of_birth[0];
                            $parent_signup.find('.date-error').show().attr('data-title',date).addClass('after-show');
                        }

                        setTimeout(function(){
                            $parent_signup.find('.error').removeClass('after-show');
                        },3000);
                    }
                })
            });

            $parent_signup.find('input').keyup(function (event) {
                if (event.keyCode === 13) {
                    $('#signup').trigger('click');
                }
            });
        })
    </script>
    @endpush
@endif