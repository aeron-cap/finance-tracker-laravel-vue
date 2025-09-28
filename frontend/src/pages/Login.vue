<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
      <div>
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900 dark:text-white">
          Sign in to your account
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600 dark:text-gray-400">
          Welcome back! Please sign in to continue
        </p>
      </div>
      
      <div class="mt-8">
        <div class="flex justify-center">
          <button 
            @click="google_login()" 
            class="group relative w-full flex justify-center items-center gap-3 py-3 px-4 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-400 dark:hover:border-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out shadow-sm hover:shadow-md"
          >
            <img 
              class="w-5 h-5" 
              src="https://www.svgrepo.com/show/475656/google-color.svg" 
              loading="lazy" 
              alt="Google logo"
            >
            <span>Continue with Google</span>
          </button>
        </div>
      </div>
      
      <div class="text-center">
        <p class="text-xs text-gray-500 dark:text-gray-400">
          Only sign in with google option, more coming soon!
        </p>
      </div>
    </div>
  </div>
</template>

<script setup>

import GuestLayout from '../components/GuestLayout.vue';
import { ref } from 'vue';

const error = ref(null);
const loading = ref(false);

async function google_login() {
  window.location.href = "http://localhost:8000/api/auth/google/redirect";
}

</script>

<style lang="scss" scoped>

</style>