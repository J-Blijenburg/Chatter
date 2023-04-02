<template>
  <div class="structure">
    <Navigation />
    <div class="base">
      <div class="baseHeader">
        <h1>Welcome, {{ user.username }}</h1>
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
        })
        .catch((error) => console.log(error));
    },
  }

}
</script>
  
<style>
@import '../assets/css/start.css';
</style>