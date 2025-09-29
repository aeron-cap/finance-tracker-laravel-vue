<template>
  <div
    class="min-h-screen flex flex-col items-center justify-center bg-cover bg-center relative"
    :style="{ backgroundImage: `url(${backgroundImage})` }"
  >

    <div class="absolute inset-0 bg-black/70 dark:bg-black/70"></div>

    <div
      class="relative w-full max-w-2xl lg:max-w-3xl space-y-10 p-10 lg:p-14 rounded-2xl shadow-2xl bg-gray-50/95 dark:bg-gray-900/90 backdrop-blur-md"
    >
      <div class="mb-8 text-center group">
        <h1
          class="text-5xl sm:text-6xl lg:text-7xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-500 via-orange-500 to-green-500 transition duration-500 ease-in-out group-hover:from-orange-500 group-hover:via-green-500 group-hover:to-blue-500"
        >
          Finance++
        </h1>
        <p
          class="mt-3 text-base sm:text-lg lg:text-xl text-gray-600 dark:text-gray-400 transition-colors duration-300 group-hover:text-gray-800 dark:group-hover:text-gray-200"
        >
          Manage your finances smarter
        </p>
      </div>

      <div>
        <h2 class="text-center text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white">
          Sign in to your account
        </h2>
        <p class="mt-2 text-center text-base sm:text-lg text-gray-600 dark:text-gray-400">
          Welcome back! Please sign in to continue
        </p>
      </div>

      <div class="mt-8">
        <div class="flex justify-center">
          <button 
            @click="google_login()" 
            class="relative w-full flex justify-center items-center gap-3 py-4 px-6 rounded-lg text-base sm:text-lg font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 shadow-sm transition-all duration-300 ease-in-out 
            hover:shadow-lg hover:scale-[1.03] hover:border-transparent hover:text-white hover:bg-gradient-to-r hover:from-blue-500 hover:via-orange-500 hover:to-green-500 cursor-pointer"
          >
            <img 
              class="w-6 h-6 sm:w-7 sm:h-7" 
              src="https://www.svgrepo.com/show/475656/google-color.svg" 
              loading="lazy" 
              alt="Google logo"
            >
            <span>Continue with Google</span>
          </button>
        </div>
      </div>

      <div class="text-center">
        <p class="text-sm sm:text-base text-gray-500 dark:text-gray-400">
          Only sign in with Google option, more coming soon!
        </p>
      </div>
    </div>

    <div class="absolute bottom-1 right-2 text-[8px] sm:text-xs text-gray-300 dark:text-gray-400">
      Photo by <a href="https://www.freepik.com/author/kamranaydinov" target="_blank" class="underline hover:text-white">KamranAydinov</a>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import backgroundImage from '../assets/images/workspace-with-office-supplies.jpg';

const error = ref(null);
const loading = ref(false);

async function google_login() {
  window.location.href = "http://localhost:8000/api/auth/google/redirect";
}
</script>


<style lang="scss" scoped>

</style>
