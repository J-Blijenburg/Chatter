<template>
    <div class="structure">
        <Navigation />
        <div class="base">
            <div class="baseHeader">
                <h1>Profile</h1>
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


}
</script>
    
<style>
@import '../assets/css/profile.css';
</style>