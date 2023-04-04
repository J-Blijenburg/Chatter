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
                                    :class="{ 'active': selectedUser === user.id }"
                                    @click="selectedUser = user.id, getChatWithFriend()">
                                    {{ user.username }}
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div id="chat" class="col-md-12">
                                    <div class="scrollbar" ref="chatBox">
                                        <div class="chat-box" v-for="msg in message" :key="msg.id">
                                            <div v-if="msg.fromUser !== selectedUser" class="chat-message-User">
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
                                            <input @keydown.enter.prevent="sendMessage()" type="text" class="form-control"
                                                placeholder="Enter text message...">
                                            <button @click="sendMessage()" class="btn btn-primary" type="button"
                                                id="button-addon2">Send</button>
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
            selectedUser: '',
            hoveredUser: ''
        }
    },
    mounted() {
        this.getFriends();
    },
    methods: {
        getFriends() {
            axios.get("http://localhost/friends/getChatFriendsByUserId", {
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("token"),
                }
            })
                .then((res) => {
                    this.users = res.data;
                })
                .catch((error) => console.log(error));
        },
        getChatWithFriend() {
            axios.get("http://localhost//messages/getMessagesById/" + this.selectedUser, {
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("token"),
                }
            })
                .then((res) => {
                    this.message = res.data;
                    this.$nextTick(() => {
                        this.$refs.chatBox.scrollTop = this.$refs.chatBox.scrollHeight;
                    });
                })
                .catch((error) => console.log(error));
        },
        sendMessage() {
            axios.post("http://localhost/messages/createMessage", {
                toUser: this.selectedUser,
                textMessage: document.querySelector("input").value,
                sendAt: "2023-04-02 16:11:52"
            }, {
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("token")
                }
            })
                .then((res) => {
                    document.querySelector("input").value = "";
                    this.getChatWithFriend();
                    this.$nextTick(() => {
                        this.$refs.chatBox.scrollTop = this.$refs.chatBox.scrollHeight;
                    });
                })
                .catch((error) => console.log(error));
        }
    }


}
</script>
    
<style>
@import '../assets/css/chats.css';
</style>