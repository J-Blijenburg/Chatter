<template>
  <Navigation />
  <div class="homeStructure">

    <div class="homeTitle">
      <h1>Welcome To Chatter!</h1>
    </div>
    <div class="homeButtons">
      <button @click="login()" class="btnLoginRegister">Login</button>
      <button @click="register()" class="btnLoginRegister">Register</button>
      <!-- <p>Chatter is a social media platform that allows you to connect with your friends and family.</p> -->
    </div>
  </div>
</template>

<script>
  export default {
    name: "Home",
    methods: {
      login() {
        this.$router.push("/login");
      },
      register() {
        this.$router.push("/register");
      },
    },
  };
</script>

<style></style>