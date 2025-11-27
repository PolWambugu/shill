<script setup>
import {ref} from 'vue'
import {useRouter} from"vue-router";


const showPassword = ref(false)



const email = ref(null)
const password = ref(null)

function Login(){
    try {
        
        let user = JSON.parse(localStorage.getItem( "signUpData"));
        
        if(email.value = user.email && password.value == user.password){
            localStorage.setItem( "isLoggedIn", true );
            router.push('/')

        }else{
            console.log("Invalid credentials")
        }

        
    } catch (err) {
        console.error('Sign up process failed', err)
    }

}
</script>

<template>
    <v-container align="center">
        <v-row>
            <v-col>
                <v-card class="pa-6" width="600" color="deep-purple-lighten-1">
                    <v-card-title>Login</v-card-title>
                    <v-text-field v-model="email" label="Email Address" :rules="[
                            (v) => !!v || 'Email is required',
                            (v) => /.+@.+\..+/.test(v) || 'Email must be valid',
                        ]"
                        required></v-text-field>
                    <v-text-field v-model="password" label="Password" :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                        :type="showPassword ? 'text' : 'password'"
                        @click:append="showPassword = !showPassword"
                        :rules="[
                            (v) => !!v || 'Password is required',
                            (v) => v.length >= 8 || 'Password must be at least 8 characters',
                        ]" ></v-text-field>
                    
                    <v-card-text>
                        Don't have an  account?
                        <router-link to="/signup">Signup</router-link>
                    </v-card-text>
                    <v-card-actions>
                        <v-btn color="white" variant="elevated" @click="Login()">Login</v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>