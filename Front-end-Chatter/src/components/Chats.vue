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
                                <li class="list-group-item" v-for="user in users" :key="user.id">{{ user.username }}</li>
                            </ul>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div id="chat" class="col-md-12">
                                    <div class="chat-box">
                                        <div class="chat-message">
                                            <p>John: Hi, how are you?</p>
                                        </div>
                                        <div class="chat-message">
                                            <p>You: I'm good, thanks for asking.</p>
                                        </div>
                                        <div class="chat-message">
                                            <p>John: That's great to hear.</p>
                                        </div>
                                        <div class="chat-message">
                                            <p>John: Did you finish the project?</p>
                                        </div>
                                        <div class="chat-message">
                                            <p>You: Yes, I did. How about you?</p>
                                        </div>
                                        <div class="chat-message">
                                            <p>John: Not yet, I still have a few things to do.</p>
                                        </div>
                                    </div>
                                        
                                        
                                    <form>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Enter text message...">
                                            <button class="btn btn-primary" type="button"
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
        };
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
    }


}
</script>
    
<style>
@import '../assets/css/chats.css';</style>