<template >
    <form v-show="show.length">
        <div class="hidden-responsive">
            <div class="form-group">
                <div class="form-label">Your Message</div>
                <textarea v-model="newMessage" @keyup.enter="sendMessage" name="message" class="form-input chat-message"
                          :placeholder="'Reply @'+user_name.replace('-', ' ')"></textarea>
            </div>
            <button  @click="sendMessage" class="btn btn-right color-1 size-2 hover-1">reply</button>
        </div>
        <div class="visible-responsive hidden responsive-form">
            <div class="form-group">
                <div class="form-label">Your Message</div>
                <textarea v-model="newMessage" @keyup.enter="sendMessage" name="message" class="form-input"
                          :placeholder="'Reply @'+user_name.replace('-', ' ')"></textarea>
                <button  @click="sendMessage" class="btn btn-right color-1 size-2 hover-1">reply</button>
            </div>
        </div>
    </form>
</template>

<script>
    export default {
        props: ['from_id','to_id','user_name','show'],


        data() {
            return {
                newMessage: ''
            }
        },

        methods: {
            sendMessage(e) {
                e.preventDefault();
                if(this.newMessage.trim() == ''){
                    return false;
                }
                let date = new Date();
                let M = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
                this.$emit('messagesent', {
                    from_id: this.from_id,
                    message: this.newMessage,
                    to_id:this.to_id,
                    created_at:(M[date.getMonth()]) + ' ' + date.getDate() + ', ' +  date.getFullYear() + ' ' + date.getHours() + ":" + date.getMinutes() + 'am'
                });

                this.newMessage = '';
                setTimeout(function () {
                    let elem = document.getElementById('chat-block');
                    $("#chat-block").animate({ scrollTop: elem.scrollHeight }, "normal");
                },200);
            }
        }
    }

    function formatAMPM(date) {
        let hours = date.getHours();
        let minutes = date.getMinutes();
        let ampm = hours >= 12 ? 'pm' : 'am';
        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'
        minutes = minutes < 10 ? '0'+minutes : minutes;
        let strTime = hours + ':' + minutes + ' ' + ampm;
        return strTime;
    }
</script>