<template>
    <div class="structure">
        <Navigation />
        <div class="base">
            <div class="baseAddFriendsHeader">
                <h1>Add User</h1>
            </div>
            <div class="baseAddFriendsBody">
                <div class="addUser">
                    <h3 class="addFriendTitle">Add Friend</h3>
                    <div id="addFriendInputField" class="input-group">
                        <input v-model="secondUser" type="number" class="form-control"
                            placeholder="Enter user id of your friend">
                        <button @click="addFriend()" class="btn btn-primary" type="button" id="button-addon2">Send</button>
                    </div>
                </div>
                <div class="addUser">
                    <h3 class="addFriendTitle">Add Random User</h3>
                    <div @click="addRandomUser()" class="btnRandomUser">
                        <button class="btn btn-primary">Add Random User</button>
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
    name: "AddFriends",
    components: {
        Navigation
    },
    data() {
        return {
            secondUser: null
        }
    },
    methods: {
        addFriend() {
            axios.post("http://localhost/friends/addFriend/" + this.secondUser, null,  {
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("token"),
                }
            })
                .then((res) => {
                    this.$router.push("/friends");
                })
                .catch((err) => {
                    console.log(err);
                })
        },
        addRandomUser() {
            axios.post("http://localhost/friends/addRandomUser/", null, {
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("token"),
                }
            })
                .then((res) => {
                    this.$router.push("/friends");
                })
                .catch((err) => {
                    console.log(err);
                })
        }
    }


}
</script>
    
<style>
@import '../assets/css/addFriends.css';
</style>