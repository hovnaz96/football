<template>
    <div v-show="message_users.length">
        <div class="noto-entry style-3 user-box-chat" v-bind:class="[user.id == first_user_id ? 'user-box-chat-active' : '']" v-bind:data-id="user.id" v-for="user in message_users" @click="showMessages(user.id,user.full_name)">
            <div class="noto-content clearfix">
                <div class="noto-img">
                    <a :href="user.user_profile_url">
                        <img :src="user.user_profile_image_large" alt="" class="be-ava-comment">
                    </a>
                </div>
                <div class="noto-text">
                    <div class="noto-text-top">
                        <span class="noto-name"><a :href="user.user_profile_url">{{ user.full_name }}</a></span>
                        <span class="noto-date pull-right"><i class="fa fa-clock-o"></i> {{ user.last_message.created_at }}</span>
                    </div>
                    <div class="noto-message">{{ user.last_message.message }}</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['message_users','first_user_id','first_user_name'],

        updated(){
            let location  = window.location.href.split('/');
            if($.isNumeric(location[location.length - 2])){
                this.showMessages(location[location.length - 2],location[location.length - 1]);
                this.$emit('current_user_chat', location[location.length - 2]);
            }else{
                this.showMessages(this.first_user_id,this.first_user_name);
                this.$emit('current_user_chat', this.first_user_id);
            }
        },

        methods: {
            showMessages(user_id,user_name){
                this.fetchMessagesByID(user_id);
                this.$emit('usermame', user_name);
                this.$emit('toid', user_id);
                this.$emit('current_user_chat', user_id);
                $('.user-box-chat').removeClass('user-box-chat-active');
                $('.user-box-chat[data-id='+user_id+']').addClass('user-box-chat-active');
            },


            fetchMessagesByID(user_id) {
                axios.post('/messages/'+user_id).then(response => {
                    this.$emit('messagerefresh', response.data);
                    if(response.data){
                        setTimeout(function () {
                            let elem = document.getElementById('chat-block');
                            $("#chat-block").animate({ scrollTop: elem.scrollHeight }, "fast");
                        },200);
                    }
                });
            },
        },
    };
</script>