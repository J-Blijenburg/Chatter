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
                <button type='button' class="btnLogin">Submit</button>
            </form>
        </div>
    </div>
</template>
  
<script>

</script>
  
<style>
@import '../assets/css/login.css';
</style>