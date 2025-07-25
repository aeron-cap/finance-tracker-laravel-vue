<template>
    <GuestLayout>
        <div class="relative">
            <transition
                name="fade"
                enter-active-class="transition ease-out duration-300"
                enter-from-class="opacity-0"
                enter-to-class="opacity-100"
                leave-active-class="transition ease-in duration-200"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <div
                    v-if="error"
                    class="absolute left-1/2 -translate-x-1/2 top-2 z-50 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded shadow-lg w-[90%] max-w-md"
                    role="alert"
                >
                    <strong class="font-bold">{{ error.message }}</strong>
                </div>
            </transition>
        </div>

        <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">Login</h2>
        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form @submit.prevent="submit" class="space-y-6">
                <div>
                    <label for="email" class="block text-sm/6 font-medium text-gray-900">Email address</label>
                    <div class="mt-2">
                        <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        autocomplete="email" 
                        required="" 
                        v-model="data.email"
                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm/6 font-medium text-gray-900">Password</label>
                    </div>
                    <div class="mt-2">
                        <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        autocomplete="current-password" 
                        required="" 
                        v-model="data.password"
                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                    </div>
                </div>

                <div>
                    <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Login
                    </button>
                </div>
            </form>

            <p class="mt-10 text-center text-sm/6 text-gray-500">
                Want to Join?
                {{ ' ' }}
                <RouterLink :to="{name: 'Register'}" class="font-semibold text-indigo-600 hover:text-indigo-500">
                    Create an account here
                </RouterLink>
            </p>
        </div>
    </GuestLayout>
</template>

<script setup>

import { RouterLink } from 'vue-router';
import GuestLayout from '../components/GuestLayout.vue';
import { ref } from 'vue';
import router from '../router';
import axios from '../lib/axios';

const data = ref({
    email: '',
    password: ''
});

const error = ref(null);
let user = ref(null);

async function submit() {
    error.value = false;
    try {
        await axios.get('/sanctum/csrf-cookie');
        await axios.post('/api/login', data.value).then((response) => {
            localStorage.setItem('token', response.data.token);
        });

        const user_response = await axios.get("/api/user");
        user = user_response.data;

        if (user_response.status === 200) {
            router.push({ name: 'Home' });
        }

    } catch (e) {
        error.value = e;

        setTimeout(() => {
            error.value = null;
        }, 3000);
    }
}

</script>

<style lang="scss" scoped>

</style>