@if(Auth::check())
    <div class="large-popup send-m" id="chat-send">
        <div class="large-popup-fixed"></div>
        <div class="container large-popup-container">
            <div class="row">
                <div class="col-md-10 col-md-push-1 col-lg-8 col-lg-push-2 large-popup-content">
                    <div class="row">
                        <div class="col-md-12">
                            <i class="fa fa-times close-m close-button"></i>
                            <h5 class="large-popup-title">Send message</h5>
                        </div>
                        <form action="./" class="popup-input-search">
                            <div class="col-md-12">
                                <textarea id='send-message' class="message-area" placeholder="Message"></textarea>
                                <i class="fa fa-times error message-error"  title=""></i>
                            </div>
                            <div class="col-md-12 for-signin">
                                <input type="submit" class="be-popup-sign-button send-message send-button" value="SEND">
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
                $('.send-message').click(function(e){
                    var $parent = $('#chat-send');
                    e.preventDefault();
                    if($(this).hasClass('disable')){
                        return false;
                    }
                    $('#send-message, .send-button').addClass('disable').click(false);
                    var self = $(this);
                    self.addClass('disable');
                    $.ajax({
                        url:'{{ url('/messages_ajax') }}',
                        type:'POST',
                        data:{
                            _token:'{{ csrf_token() }}',
                            to_id:$('#message-id').data('id'),
                            message:$('#send-message').val()
                        },
                        success:function(){
                            $('.close-m').trigger('click');
                            $(' #send-message').val('');
                            $('.send-message , #send-message , .send-button').removeClass('disable').click(true);
                        },
                        error:function(res){
                            var error = res.responseJSON;
                            $parent.find('.error').hide();
                            if (error.message) {
                                $parent.find('.message-error').show().attr('data-title',error.message).addClass('after-show');
                            }

                            setTimeout(function(){
                                $parent.find('.error').removeClass('after-show');
                            },1000);

                            $('#send-message').removeClass('disable').click(true);
                        }
                    });
                })
            });
        </script>
    @endpush

@endif