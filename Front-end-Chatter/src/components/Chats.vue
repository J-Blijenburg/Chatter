<template>
    <div class="structure">
        <Navigation />
        <div class="base">
            <div class="baseHeader">
                <h1>Chats</h1>
            </div>
        </div>
    </div>
</template>
    
<script>
import axios from 'axios';
import Navigation from './Navigation.vue'

export default {
    name: "Chats",
    components: {
        Navigation
    },


}
</script>
    
<style>
@import '../assets/css/chats.css';
</style>