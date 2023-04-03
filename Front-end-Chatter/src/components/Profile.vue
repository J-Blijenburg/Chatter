<template>
    <div class="structure">
        <Navigation />
        <div class="base">
            <div class="baseProfileHeader">
                <h1>Profile</h1>
            </div>
            <div class="baseProfileBody">
                <div class="changeProfileSettings">
                    <div class="profileItemSettings">
                        <div class="layoutProfileSettings">
                            <h6>Username</h6>
                            <input type="text" value="dasdsa">
                        </div>
                        <div class="layoutProfileSettings">
                            <h6>Email</h6>
                            <input type="text" value="Email">
                        </div>
                        <div class="layoutProfileSettings">
                            <h6>Password</h6>
                            <input type="password" value="">
                        </div>

                        <button>Change</button>
                    </div>

                    <div class="removeUser">
                        <button @click="removeUser()" class="removeUserButton">Delete account</button>
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
    name: "Profile",
    components: {
        Navigation
    },
    methods: {
        changeProfileSettings() {
            axios.post("http://localhost/users/changeProfileSettings", {
                username: localStorage.getItem("username"),
                email: localStorage.getItem("email"),
                password: localStorage.getItem("password")
            })
                .then((res) => {
                    this.$router.push("/profile");
                })
                .catch((err) => {
                    console.log(err);
                })
        },
        removeUser() {
            axios.delete("http://localhost/users/removeUser", {
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("token"),
                }
            })
                .then((res) => {
                    localStorage.clear();
                    this.$router.push("/");
                })
                .catch((err) => {
                    console.log(err);
                })
        }
    }


}
</script>
    
<style>
@import '../assets/css/profile.css';
</style>