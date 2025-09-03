<template>
    <GuestLayout>
        <div v-if="loading" class="flex justify-center items-center h-64">
            <div role="status">
                <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C0 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                </svg>
                <span class="sr-only">Loading...</span>
            </div>
        </div>

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
const loading = ref(false);

async function submit() {
    loading.value = true;
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
    loading.value = false;
}

</script>

<style lang="scss" scoped>

</style>