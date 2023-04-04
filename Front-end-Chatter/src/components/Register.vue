<template>
  <div class="registerStructure">
      <div class="register">
          <h1>Chatter</h1>
          <form class="registerPart">
              <div class="mb-3">
                  <input v-model="username" id="inputUsername" type="text" class="form-control" placeholder="Username" />
              </div>
              <div class="mb-3">
                  <input v-model="email" type="email" class="form-control" id="inputEmail" placeholder="Email" />
              </div>
              <div class="mb-3">
                  <input v-model="password" type="password" class="form-control" id="inputPassword" placeholder="Password" />
              </div>
              
             
              <button @click="register()" type='button' class="btnRegister">Submit</button>
          </form>
      </div>
  </div>
</template>

<script>
import axios from 'axios';
export default {
    methods: {
        register() {
            axios.post("http://localhost/users/register", {
                username: this.username,
                email: this.email,
                password: this.password,
            })
                .then((res) => {
                    alert(res.data.username + " has registered!");
                    this.$router.push("/");
                })
                .catch((error) => console.log(error));
        },
    }
}
</script>

<style>
@import '../assets/css/register.css';
</style>