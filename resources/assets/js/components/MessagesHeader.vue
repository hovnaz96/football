<template>
    <div>
        <div v-show="message_users.length">
            <div class="noto-entry style-2  user-box-chat" v-for="user in message_users" @click="hrefByUserChat(user.id,user.full_name)">
                <div class="noto-content clearfix">
                    <div class="noto-img">
                        <a :href="user.user_profile_url">
                            <img :src="user.user_profile_image_large"  alt="" class="be-ava-comment">
                        </a>
                    </div>
                    <div class="noto-text">
                        <div class="noto-text-top">
                            <span class="noto-name"><a :href="user.user_profile_url">{{ user.full_name }}</a></span>
                            <span class="noto-date"><i
                                    class="fa fa-clock-o"></i> {{ user.last_message.created_at }}</span>
                        </div>
                        <div class="noto-message">{{ user.last_message.message }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="no-messages-header" v-show="!message_users.length">
            Looks like you don't have any  messages yet
        </div>
    </div>
</template>

<script>
    export default {
        props: ['message_users','first_user_id','first_user_name'],

        updated(){
//            this.$emit('current_user_chat', this.first_user_id);
        },

        methods: {
            hrefByUserChat(id,name){
                    window.location = '/messages/'+id+'/'+name.replace(' ','-');
            }
        },
    };
</script>