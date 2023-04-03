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
                            <input type="text" v-model="user.username">
                        </div>
                        <div class="layoutProfileSettings">
                            <h6>Email</h6>
                            <input type="text" v-model="user.email">
                        </div>
                        <div class="layoutProfileSettings" >
                            <h6>Password</h6>
                            <input type="password" placeholder="Password" id="ChangePassword">
                        </div>

                        <button @click="changeProfileSettings()" class="btnEditUser">Change</button>
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
    data() {
        return {
            user: {
                username: "",
                email: "",
                id: "",
                password: ""
            }
        }
    },
    mounted() {
        this.getOneUser();
    },
    methods: {
        getOneUser() {
            axios.get("http://localhost/users/getOneUser", {
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("token"),
                },
            })
                .then((res) => {
                    this.user.username = res.data.data.username;
                    this.user.email = res.data.data.email;
                    this.user.id = res.data.data.id;
                    this.user.password =   res.data.data.password;
                    localStorage.setItem("userId", res.data.data.id);
                })
                .catch((error) => console.log(error));
        },
        changeProfileSettings() {
            axios.put("http://localhost/users/changeProfileSettings", {
                id: this.user.id,
                username: this.user.username,
                email: this.user.email,
                password:  document.getElementById("ChangePassword").value,
            })
                .then((res) => {
                    alert(document.getElementById("ChangePassword").value);
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