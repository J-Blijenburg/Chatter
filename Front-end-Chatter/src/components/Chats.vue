<template>
    <div class="structure">
        <Navigation />
        <div class="base">
            <div class="baseChatsHeader">
                <h1>Chats</h1>
            </div>
            <div class="baseChatsBody">
                <div class="container-fluid" style="height: 100%;">
                    <div class="row">
                        <div id="chatContacts" class="col-md-3">
                            <ul class="list-group">
                                <li class="list-group-item" v-for="user in users" :key="user.id"
                                    :class="{ 'active': activeUser === user.id }"
                                    @click="activeUser = user.id, getChatWithFriend()">
                                    {{ user.username }}
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div id="chat" class="col-md-12">
                                    <div>
                                        <div class="chat-box" v-for="msg in message" :key="msg.id">
                                            <div v-if="msg.fromUser === 6" class="chat-message-User">
                                                <div class="message">
                                                        {{ msg.textMessage }}

                                                    </div>
                                            </div>
                                            <div v-else class="chat-message-Friend">
                                                <p>
                                                    <div class="message">
                                                        {{ msg.textMessage }}

                                                    </div>
                                                </p>
                                            </div>
                                        </div>
                                    </div>



                                    <form>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Enter text message...">
                                            <button class="btn btn-primary" type="button" id="button-addon2">Send</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</template>
    
<script>
import axios from 'axios';
import Navigation from './Navigation.vue'

export default {
    name: "Chats",
    components: {
        Navigation
    },
    data() {
        return {
            users: [],
            message: [],
            activeUser: '',
            hoveredUser: ''
        }
    },
    mounted() {
        this.getFriends(localStorage.getItem("userId"));
    },
    methods: {
        getFriends(id) {
            axios.get("http://localhost/friends/getChatFriendsByUserId/" + id)
                .then((res) => {
                    this.users = res.data;
                })
                .catch((error) => console.log(error));
        },
        getChatWithFriend() {
            axios.get("http://localhost//messages/getMessagesById/" + localStorage.getItem("userId") + "/" + this.activeUser)
                .then((res) => {
                    console.log(res.data);
                    this.message = res.data;
                })
                .catch((error) => console.log(error));
        }
    }


}
</script>
    
<style>
@import '../assets/css/chats.css';
</style>