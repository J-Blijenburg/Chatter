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
                            <div class="friendImageUsername">
                                <div class="friendImage">
                                    <img :src="profileImage[user.id]" class="image" />
                                </div>
                                {{ user.username }}
                            </div>

                            <div class="btnFriendsOptions">
                                <button @click="StartChat(user.id)" class="btn btn-primary btn-sm float-right">Chat</button>
                                <button @click="removeFriendship(user.id)" class="btn btn-danger btn-sm float-right">Remove
                                    <br>
                                    Friend</button>
                            </div>

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
            profileImage: [],
        };
    },
    mounted() {
        this.getFriends();
    },
    methods: {
        getFriends() {
            axios.get("http://localhost/friends/getFriendsByUserId", {
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("token"),
                }
            })
                .then((res) => {
                    this.users = res.data;
                    this.users.forEach(user => {
                        this.getProfileImagesByFriendId(user.id);
                    });
                })
                .catch((error) => console.log(error));
        },
        StartChat(friendId) {
            axios.put("http://localhost/friends/startChat/" + friendId, null, {
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("token")
                }
            })
                .then((res) => {
                    this.$router.push("/chats");
                })
                .catch((error) => console.log(error));
        }, getProfileImagesByFriendId(friendId) {
            axios.get("http://localhost/friends/getProfileImagesByFriendId/" + friendId)
                .then((res) => {
                    this.profileImage[friendId] = res.data;
                })
                .catch((err) => {
                    console.log(err);
                })
        }, removeFriendship(friendId) {
            axios.delete("http://localhost/friends/removeFriendship/" + friendId, null, {
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("token")
                }
            }).then((res) => {
                alert("Friendship over ;(");
            })
                .catch((err) => {
                    console.log(err);
                })
        }
    }


}
</script>
    
<style>
@import '../assets/css/friends.css';
</style>