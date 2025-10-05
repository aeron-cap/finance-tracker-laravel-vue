<template>
  <div class="min-h-screen flex flex-col items-center justify-center bg-slate-900 relative overflow-hidden">
    <div class="gradient-orb-1 absolute top-0 left-1/4 w-96 h-96 bg-blue-500/20 rounded-full blur-3xl"></div>
    <div class="gradient-orb-2 absolute bottom-0 right-1/4 w-96 h-96 bg-purple-500/20 rounded-full blur-3xl"></div>
    <div class="gradient-orb-3 absolute top-1/2 left-1/2 w-72 h-72 bg-pink-500/15 rounded-full blur-3xl"></div>

    <div class="absolute inset-0 bg-slate-900/40"></div>

    <div class="absolute top-2 left-2 text-xs text-gray-200">
      <RouterLink :to="{name: 'Landing'}" class="flex">
        <svg class="w-4 h-4 text-gray-500 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 6">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M13 5H1m0 0 4 4M1 5l4-4"/>
        </svg>
        <p class="pl-2">Back to Landing</p>
      </RouterLink>
    </div>

    <div
      class="relative w-full max-w-md lg:max-w-lg mx-4 space-y-8 p-8 sm:p-10 rounded-2xl shadow-2xl backdrop-blur-md bg-slate-800/50 border border-gray-700/50 hover:border-gray-600/50 transition-all duration-300"
    >
      <div class="text-center space-y-3 group">
        <h1
          class="text-4xl sm:text-5xl lg:text-6xl font-extrabold bg-gradient-to-r from-blue-500 to-purple-500 bg-clip-text text-transparent transition-all duration-500"
        >
          Finance++
        </h1>
        <p
          class="text-base sm:text-lg text-gray-400 transition-colors duration-300 group-hover:text-gray-300"
        >
          Manage your finances smarter & simpler
        </p>
      </div>

      <div class="space-y-2">
        <h2 class="text-center text-2xl sm:text-3xl font-bold text-white">
          Sign in to your account
        </h2>
        <p class="text-center text-base text-gray-400">
          Welcome! Please sign in to continue
        </p>
      </div>

      <div class="pt-4">
        <button
          @click="google_login()"
          class="w-full flex justify-center items-center gap-3 py-4 px-6 rounded-xl text-base sm:text-lg font-medium text-white bg-slate-700/50 border border-gray-600/50 backdrop-blur-sm shadow-lg transition-all duration-300 hover:bg-slate-700/70 hover:border-gray-500 hover:shadow-xl hover:shadow-blue-500/20 hover:scale-[1.02] active:scale-[0.98]"
        >
          <img
            class="w-5 h-5 sm:w-6 sm:h-6"
            src="https://www.svgrepo.com/show/475656/google-color.svg"
            loading="lazy"
            alt="Google logo"
          />
          <span>Continue with Google</span>
        </button>
      </div>

      <div class="text-center pt-4">
        <p class="text-sm sm:text-base text-gray-500">
          More sign-in options coming soon!
        </p>
      </div>
    </div>

    <div class="absolute bottom-2 right-2 text-xs text-gray-500">
      Photo by 
      <a 
        href="https://www.freepik.com/author/kamranaydinov" 
        target="_blank" 
        class="underline hover:text-gray-300 transition-colors"
      >
        KamranAydinov
      </a>
    </div>
  </div>
</template>

<script setup>
import { RouterLink } from 'vue-router';
import Landing from './Landing.vue';

async function google_login() {
  window.location.href = "http://localhost:8000/api/auth/google/redirect";
}

</script>

<style scoped>

</style>