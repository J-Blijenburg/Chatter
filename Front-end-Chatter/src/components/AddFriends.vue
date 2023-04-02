<template>
    <div class="structure">
        <Navigation />
        <div class="base">
            <div class="baseHeader">
                <h1>Add Friends</h1>
            </div>
        </div>
    </div>
</template>
    
<script>
import axios from 'axios';
import Navigation from './Navigation.vue'

export default {
    name: "AddFriends",
    components: {
        Navigation
    },


}
</script>
    
<style>
@import '../assets/css/addFriends.css';
</style>