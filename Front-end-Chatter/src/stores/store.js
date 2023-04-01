import { defineStore } from 'pinia';
import axios from "../axios-auth";

export const userHenkStore = defineStore('henk', {
    state: () => ({
        username: 'Henk',
        jwt: ''
    }),
    getters: {
        isLoggedIn: (state) => {
            return state.jwt !== '';
        }
    },
    actions: {
        login(jwt) {
            return new Promise((resolve, reject) => {
                axios.post("users/login", {
                    username: this.username,
                    password: this.password,
                    
                })
                    .then((res) => {
                        console.log(res);
                        axios.defaults.headers.common['Authorization'] = "Bearer " + res.data.jwt
                        this.jwt = res.data.jwt;
                        this.username = this.username;
                        console.log("logged in  " + this.username);
                        resolve();
                    })
                    .catch((error) => {
                        console.log(error);
                        reject($error);
                    }
                    
                    );
            });
        }
    }
});