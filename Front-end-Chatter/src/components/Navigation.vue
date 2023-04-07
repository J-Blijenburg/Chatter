<template>
    <div class="navigation">


        <div>
            <div class="navigationIcons">
                <a href="/profile">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                        class="bi bi-person-fill" viewBox="0 0 16 16">
                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                    </svg>
                </a>
                <p class="navigationIconsName">Profile</p>
            </div>
            <div class="navigationIcons">
                <a href="/friends">
                    <svg xmlns="http://www.w3.org/2000/svg" width="46" height="46" fill="currentColor"
                        class="bi bi-people-fill" viewBox="0 0 16 16">
                        <path
                            d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                    </svg>
                </a>
                <p class="navigationIconsName">Friends</p>
            </div>
            <div class="navigationIcons">
                <a href="/addfriends">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                        class="bi bi-person-fill-add" viewBox="0 0 16 16">
                        <path
                            d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0Zm-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        <path
                            d="M2 13c0 1 1 1 1 1h5.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.544-3.393C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4Z" />
                    </svg>
                </a>
                <p class="navigationIconsName">Add</p>
            </div>

            <div class="navigationIcons">
                <a href="/chats">
                    <svg xmlns="http://www.w3.org/2000/svg" width="42" height="42" fill="currentColor"
                        class="bi bi-chat-text-fill" viewBox="0 0 16 16">
                        <path
                            d="M16 8c0 3.866-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.584.296-1.925.864-4.181 1.234-.2.032-.352-.176-.273-.362.354-.836.674-1.95.77-2.966C.744 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7zM4.5 5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7zm0 2.5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7zm0 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4z" />
                    </svg>
                </a>
                <p class="navigationIconsName">Chats</p>
            </div>
        </div>
        <div class="navigationBottom">
            
            <button @click="logout()" class="btnLogOut">Log out</button>
        </div>
    </div>
</template>
    
<script>
 export default {
    name: "navigation",
    methods: {
      logout() {
        localStorage.clear();
        this.$router.push("/");
      }
    },
  };
</script>
    
<style>
@import '../assets/css/navigation.css';
</style>