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
                        <input type="text" class="form-control" placeholder="Enter text message...">
                        <button class="btn btn-primary" type="button" id="button-addon2">Send</button>
                    </div>
                </div>
                <div class="addUser">
                    <h3 class="addFriendTitle">Add Random User</h3>
                    <div class="btnRandomUser">
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


}
</script>
    
<style>
@import '../assets/css/addFriends.css';
</style>