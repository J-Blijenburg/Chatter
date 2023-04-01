<template>
  <section>
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <form>
            <div class="mb-3">
              <label for="inputUsername" class="form-label">Username</label>
              <input v-model="username" id="inputUsername" type="text" class="form-control" />
            </div>
            <div class="mb-3">
              <label for="inputPassword" class="form-label">Password</label>
              <input v-model="password" type="password" class="form-control" id="inputPassword" />
            </div>
            <button @click="login()" type='button' class="btn btn-primary">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import { userHenkStore } from "../stores/store";

import axios from "../axios-auth";
export default {
  setup() {
    return { store: userHenkStore() };
  },
  name: "Login",
  data() {
    return {
      username: "",
      password: "",
    };
  },
  methods: {
    login() {
      this.store.login(this.username, this.password)
        .then(result => {
          this.$router.push('/products')
        }).catch(error => {
          console.log(error)
        })
    }
  }
};
</script>

<style></style>