<template>
    <div>
        <div v-show="messages.length">
            <div class="info-block style-2 header-block">
                <div class="be-large-post-align message-with-text">
                    <h3 class="info-block-label">Message with {{ user_name.replace('-', ' ') }}</h3>
                </div>
            </div>
            <div class="be-large-post-align" id="chat-block">
                <div>
                    <div class="be-comment responsive-overflow_hidden-margin-0" v-for="message in messages">
                        <div class="be-img-comment width-0 ">
                            <a href="">
                                <img :src="message.from_id.user_profile_image_medium" alt="" class="be-ava-comment message-avatar">
                            </a>
                        </div>
                        <div class="be-comment-content">
                            <span class="be-comment-name messages-name">
                                <a href="">{{ message.from_id.full_name }}</a>
                            </span>
                            <span class="be-comment-time time-message">
                                <i class="fa fa-clock-o"></i>{{ message.created_at }}
                            </span>
                            <p class="be-comment-text message-text">
                                {{ message.message }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="no-messages" v-show="!messages.length">
            Looks like you don't have any  messages yet
        </div>
    </div>
</template>

<script>
    export default {
        props: ['messages', 'user_name'],
    };


</script>