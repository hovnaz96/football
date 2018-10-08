Vue.component('chat-form', require('./components/ChatForm.vue'));
Vue.component('chat-messages', require('./components/ChatMessages.vue'));
Vue.component('messages-users', require('./components/MessagesUsers.vue'));

var timeout;

const chat = new Vue({
    el: '#chat',

    data: {
        messages: [],
        message_users:[],
        user_name:'User',
        to_id:'',
        first_user_id:'0',
        first_user_name:'User',
        current_user_chat:'0'
    },

    created() {
        // this.fetchMessagesByID(2);
        this.fetchUsers();

        var date = new Date();
        var  M = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        Echo.private('chat')
            .listen('MessageSent', (e) => {
            if(this.current_user_chat == e.from_id.id){
            this.messages.push({
                message: e.message.message,
                from_id: e.from_id,
                created_at:(M[date.getMonth() + 1]) + ' ' + date.getDate() + ', ' +  date.getFullYear() + ' ' + formatAMPM(date)
            });
        }

        clearTimeout(timeout);
        changeHeight();
    });
    },


    methods: {
        // fetchMessages() {
        //     axios.get('/messages').then(response => {
        //         this.messages = response.data;
        //     });
        // },

        // fetchMessagesByID(user_id) {
        //     axios.post('/messages/'+user_id).then(response => {
        //         this.messages = response.data;
        //          console.log(this.messages);
        //     });
        // },

        fetchUsers(){
            axios.get('/messagesUsers').then(response => {
                if(response.data.length){
                this.first_user_id = response.data[0].id;
                this.first_user_name = response.data[0].full_name;
            }
            this.message_users = response.data;
        });
        },


        refreshMessages(message) {
            this.messages = message;
        },

        userName(name) {
            this.user_name = name;
        },

        setToID(id) {
            this.to_id = id;
        },

        setCurrentUserChat(id){
            this.current_user_chat = id;
        },

        addMessage(message) {
            this.messages.push(message);
            // this.messages.push(this.to_id);
            axios.post('/messages', message).then(response => {

            });
        }
    }
});


function changeHeight() {
    timeout = setTimeout(function(){
        var objDiv = document.getElementById("chat-block");
        objDiv.scrollTop = objDiv.scrollHeight;
    },300);
}

function formatAMPM(date) {
    var hours = date.getHours();
    var minutes = date.getMinutes();
    var ampm = hours >= 12 ? 'pm' : 'am';
    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    minutes = minutes < 10 ? '0'+minutes : minutes;
    var strTime = hours + ':' + minutes + ' ' + ampm;
    return strTime;
}