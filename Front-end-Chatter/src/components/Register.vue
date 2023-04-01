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
              <div class="mb-3">
                  <input v-model="password" type="password" class="form-control" id="inputConfirmPassword" placeholder="Confirm Password" />
              </div>
             
              <button type='button' class="btn btn-primary">Submit</button>
          </form>
      </div>
  </div>
</template>

<script>

</script>

<style>
@import '../assets/css/register.css';
</style>