<script setup> 
import {ref} from 'vue'

const showPassword =ref(false)
const showConfirmPassword = ref(false)


const name =ref(null)
const email =ref(null)
const phone =ref(null)
const password = ref(null)


function signup(){
const signUpData = {
    'name': name.value,
     'email': email.value,
      'phone': phone.value,
        'password': password.value
}
 try{
    
    localStorage.setItem("SignUpData",JSON.stringify(signUpData));
    

} catch (err) {
    console.error('Sign Up process failed', err)}

  }





</script >

<template>
<v-container align="center">
    <v-row>
        <v-col>
            <v-card class="pa-6" width="600" color="indigo-darken-4"> 
                <v-card-title> Sign up </v-card-title>
                <v-text-field  v-model="name" label="Name" :rules="[(v) => !!v || 'Name is required']"></v-text-field>
                <v-text-field v-model="email" label="Email" 
                                        :rules="[
                            (v) => !!v || 'Email is required',
                            (v) => /.+@.+\..+/.test(v) || 'Email must be valid',
                        ]"></v-text-field>
                <v-text-field v-model="phone" label="Phone Number" type="number"></v-text-field>
                <v-text-field v-model="password" label="Password"  :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                        :type="showPassword ? 'text' : 'password'"
                        @click:append="showPassword = !showPassword"
                        :rules="[
                            (v) => !!v || 'Password is required',
                            (v) => v.length >= 8 || 'Password must be at least 8 characters',
                        ]" ></v-text-field>
                <v-text-field label="Confirm Password" :append-icon="showConfirmPassword ? 'mdi-eye' : 'mdi-eye-off'"
                        :type="showConfirmPassword ? 'text' : 'password'"
                        @click:append="showConfirmPassword = !showConfirmPassword"
                        :rules="[
                            (v) => !!v || 'Please confirm your password',
                            (v) => v === password || 'Passwords must match',
                        ]"></v-text-field>
                <v-card-text>Already registerd? 
                    <router-link to="/login">Back to login</router-link>
                </v-card-text>
                <v-card-actions>
                    <v-btn color="white" variant="elevated" @click="signup()"> Sign Up</v-btn>
                </v-card-actions>


            </v-card>
        </v-col>
    </v-row>
</v-container>
   
    
</template>