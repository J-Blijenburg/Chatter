<template>
    <div class="loginStructure">
        <div class="login">
            <h1>Chatter</h1>
            <form class="loginPart">
                <div class="mb-3">
                    <label for="inputUsername" class="form-label">Username</label>
                    <input v-model="username" id="inputUsername" type="text" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="inputPassword" class="form-label">Password</label>
                    <input v-model="password" type="password" class="form-control" id="inputPassword" />
                </div>
                <button @click="login()" type='button' class="btnLogin">Submit</button>
            </form>
        </div>
    </div>
</template>
  
<script>
import axios from 'axios';


export default {
    methods: {
        login() {
            axios.post("http://localhost/users/login", {
                username: this.username,
                password: this.password,
            })
                .then((res) => {
                    localStorage.clear();
                    localStorage.setItem("token", res.data.jwt);
                    axios.defaults.headers.common['Authorization'] = "Bearer " + res.data.jwt;
                    this.$router.push("/start");
                })
                .catch((error) => console.log(error));
        },
    }
}
</script>
  
<style>
@import '../assets/css/login.css';
</style>