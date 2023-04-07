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
                                    @click="selectedUser = user.id, getChatWithFriend(), disabled = (disabled + 1) % 2">
                                    {{ user.username }}
                                </li>
                            </ul>
                            <div>
                                <button @click="getChatWithFriend()" class="BtnRefreshChats">Refresh Chats</button>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div id="chat" class="col-md-12">
                                    <div class="scrollbar" ref="chatBox">
                                        <div class="chat-box" v-for="msg in message" :key="msg.id">
                                            <div v-if="msg.fromUser !== selectedUser" class="chat-message-User">
                                                <div class="message">
                                                    <div class="textMessage">
                                                        {{ msg.textMessage }}
                                                    </div>
                                                    <div class="dateTime">
                                                        {{ new Date(msg.sendAt).toLocaleTimeString([], {
                                                            hour: '2-digit',
                                                            minute: '2-digit'
                                                        }) }}
                                                    </div>

                                                </div>
                                            </div>
                                            <div v-else class="chat-message-Friend">
                                                <p>
                                                <div class="message-Friend">
                                                    <div class="textMessage-Friend">
                                                        {{ msg.textMessage }}
                                                    </div>
                                                    <div class="dateTime-Friend">
                                                        {{ new Date(msg.sendAt).toLocaleTimeString([], {
                                                            hour: '2-digit',
                                                            minute: '2-digit'
                                                        }) }}
                                                    </div>

                                                </div>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <form>
                                        <div class="input-group mb-3">
                                            <input :disabled="disabled != 1" @keydown.enter.prevent="sendMessage()"
                                                type="text" class="form-control" placeholder="Enter text message...">
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
import { format } from 'date-fns';

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
            hoveredUser: '',
            disabled: 0
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
                    console.log(res.data);
                    this.$nextTick(() => {
                        this.$refs.chatBox.scrollTop = this.$refs.chatBox.scrollHeight;
                    });
                })
                .catch((error) => console.log(error));
        },
        sendMessage() {
            const now = new Date();
            const formattedNow = now.toISOString().replace('T', ' ').slice(0, 19);
            axios.post("http://localhost/messages/createMessage", {
                toUser: this.selectedUser,
                textMessage: document.querySelector("input").value,
                sendAt: formattedNow
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