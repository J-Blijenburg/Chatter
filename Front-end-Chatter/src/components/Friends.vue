<template>
    <div class="structure">
        <Navigation />
        <div class="base">
            <div class="baseFriendsHeader">
                <h1>Friends</h1>
            </div>
            <div class="baseFriendsBody">
                <div id="friendsListItems" v-if="users.length > 0">
                    <ul class="list-group" id="friendsList">
                        <li id="singleFriendList" class="list-group-item" v-for="user in users" :key="user.id">
                            {{ user.username }}
                            <button @click="StartChat(user.id)" class="btn btn-primary btn-sm float-right">Chat</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>
    
<script>
import axios from 'axios';
import Navigation from './Navigation.vue'

export default {
    name: "Friends",
    components: {
        Navigation
    },
    data() {
        return {
            users: [],
        };
    },
    mounted() {
        this.getFriends();
    },
    methods: {
        getFriends() {
            axios.get("http://localhost/friends/getFriendsByUserId",{
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("token"),
                }
            })
                .then((res) => {
                    this.users = res.data;
                })
                .catch((error) => console.log(error));
        },
        StartChat(friendId) {
            axios.put("http://localhost/friends/startChat/" + friendId, null,{
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("token")
                }
            } )
                .then((res) => {
                    this.$router.push("/chats");
                })
                .catch((error) => console.log(error));
        },
    }


}
</script>
    
<style>
@import '../assets/css/friends.css';
</style>