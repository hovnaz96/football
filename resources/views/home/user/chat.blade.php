@extends('layouts.home')

@section('content')


    <div id="content-block">
        <div class="container be-detail-container" id="chat">
            <div class="row">
                <div class="col-xs-12 col-sm-5 left-feild">
                    <a href="{{ url('/') }}" class="btn color-4 size-1 hover-7"><i class="fa fa-chevron-left"></i> back
                        to home</a>
                    <form>
                        <messages-users v-on:messagerefresh="refreshMessages" v-on:usermame="userName" v-on:toid="setToID"  v-on:current_user_chat="setCurrentUserChat" :first_user_id='first_user_id'  :first_user_name='first_user_name' :message_users="message_users"></messages-users>
                    </form>
                </div>
                <div class="col-xs-12 col-sm-7">
                    <div class="be-large-post">
                        <chat-messages :messages="messages" :user_name='user_name' ></chat-messages>
                        <div class="clearfix"></div>
                        <div class="be-large-post-align">
                             <chat-form
                                    v-on:messagesent="addMessage"
                                    :from_id="{{ Auth::user() }}"
                                    :to_id="to_id"
                                    :user_name='user_name'
                                    :show="messages"
                             ></chat-form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('after-js')
    <script src="{{ asset('js/chat.js') }}"></script>
@endpush