<template>
    <div class="structure">
        <Navigation />
        <div class="base">
            <div class="baseProfileHeader">
                <h1>Profile</h1>
            </div>
            <div class="baseProfileBody">
                <div class="changeProfileSettings">
                    <div class="settingsAndProfileImage">
                        <div class="profileItemSettings">
                            <div class="layoutProfileSettings">
                                <h6>Username</h6>
                                <div class="input-group">
                                    <input type="text" class="textFields" placeholder="Username" id="txtUsername">
                                    <button @click="ChangeUsername()" class="btnEditUser">Change</button>
                                </div>
                            </div>
                            <div class="layoutProfileSettings">
                                <h6>Email</h6>
                                <div class="input-group">
                                    <input type="text" class="textFields" placeholder="Email" id="txtEmail">
                                    <button @click="ChangeEmail()" class="btnEditUser">Change</button>
                                </div>
                            </div>
                            <div class="layoutProfileSettings">
                                <h6>Password</h6>
                                <div class="input-group">
                                    <input type="text" class="textFields" placeholder="Password" id="txtPassword">
                                    <button @click="ChangePassword()" class="btnEditUser">Change</button>
                                </div>
                            </div>
                            <label id="errorMessage"></label>
                        </div>
                        <div class="profileItemSettings" id="profilesetting">
                            <div class="profileImageContainer">
                                <img :src="profileImage" class="profileImage" alt="stukkie tekst" />
                            </div>
                            <div class="uploadFile">
                                <label>
                                    <input type="file" id="file">
                                </label>
                                <button class="btnChangeProfilePicture" v-on:click="uploadImage()">Upload</button>
                            </div>
                        </div>
                    </div>
                    <div class="removeUser">
                        <button @click="removeUser()" class="removeUserButton">Delete account</button>
                    </div>


                </div>
            </div>
        </div>
    </div>
</template>
    
<script>
import axios from 'axios'
import VueAxios from 'vue-axios'
import Navigation from './Navigation.vue';

export default {
    name: "Profile",
    components: {
        Navigation
    },
    data() {
        return {
            user: {
                username: "",
                email: "",
                id: "",
                password: "",
                imageId: ""
            },
            profileImage: "",
            file: ""

        }
    },
    mounted() {
        this.getOneUser();
        this.getProfileImage();
    },
    methods: {
        getOneUser() {
            axios.get("http://localhost/users/getOneUser", {
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("token"),
                },
            })
                .then((res) => {
                    this.user.username = res.data.username;
                    this.user.email = res.data.email;
                    this.user.id = res.data.id;
                    this.user.password = res.data.password
                })
                .catch((error) => console.log(error));
        },
        ChangeUsername() {
            axios.put("http://localhost/users/updateUsername", {
                id: this.user.id,
                username: document.getElementById('txtUsername').value,
            })
                .then((res) => {
                    alert("Username is changed");
                    window.location.reload();
                })
                .catch((error) => {
                    document.getElementById("errorMessage").innerHTML = error.response.data.errorMessage;
                    console.log(error);
                })
        },
        ChangeEmail() {
            axios.put("http://localhost/users/updateEmail", {
                id: this.user.id,
                email: document.getElementById('txtEmail').value,
            })
                .then((res) => {
                    alert("Email is changed");
                    window.location.reload();
                })
                .catch((error) => {
                    document.getElementById("errorMessage").innerHTML = error.response.data.errorMessage;
                    console.log(error);
                })
        },
        ChangePassword() {
            axios.put("http://localhost/users/updatePassword", {
                id: this.user.id,
                password: document.getElementById('txtPassword').value,
            })
                .then((res) => {
                    alert("Password is changed");
                    window.location.reload();
                })
                .catch((error) => {
                    document.getElementById("errorMessage").innerHTML = error.response.data.errorMessage;
                    console.log(err);
                })
        },
        removeUser() {
            axios.delete("http://localhost/users/removeUser", {
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("token"),
                }
            })
                .then((res) => {
                    localStorage.clear();
                    this.$router.push("/");
                })
                .catch((err) => {
                    console.log(err);
                })
        }, getProfileImage() {
            axios.get("http://localhost/users/getProfileImage", {
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("token"),
                }
            }).then((res) => {
                this.profileImage = res.data;
            })
                .catch((err) => {
                    console.log(err);
                })
        },
        uploadImage() {
            this.file = document.getElementById('file').files[0];
            let formData = new FormData();
            formData.append('file', this.file);
            axios.post('http://localhost/images/uploadImage', formData, {
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("token"),
                    'Content-Type': 'multipart/form-data'
                }
            }).then((res) => {
                if (!res.data) {
                    alert('Something went wrong');
                }
                else {
                    alert('Image uploaded');
                    this.getProfileImage();
                }
            }).catch((err) => {
                console.log(err);
            })
        }

    }


}
</script>
    
<style>
@import '../assets/css/profile.css';
</style>