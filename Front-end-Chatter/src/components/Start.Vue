<template>
  <div class="structure">
    <Navigation />
    <div class="base">
      <div class="baseStartHeader">
        <h1>Welcome, {{ user.username }}</h1>
      </div>
      <div class="baseStartBody">
        <div class="baseStartText">
          <h1>Go to your friends and start a chat!</h1>
          <h5>or</h5>
          <h5>If you don't have friends</h5>
          <h1>Talk to a stranger</h1>
          <h5>Since, nothing bad can happen when talking to strangers</h5>
        </div>
      </div>
    </div>
  </div>
</template>
  
<script>
import axios from 'axios'
import Navigation from './Navigation.vue'

export default {
  name: "Start",
  components: {
    Navigation
  },
  data() {
    return {
      user: {
        username: "",
        email: "",
        id: "",
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
          localStorage.setItem("userId", res.data.data.id);
        })
        .catch((error) => console.log(error));
    },
  }

}
</script>
  
<style>
@import '../assets/css/start.css';
</style>