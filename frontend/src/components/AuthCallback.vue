<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
      <div class="text-center">
        <div class="flex justify-center mb-6">
          <div class="animate-spin rounded-full h-12 w-12 border-2 border-gray-300 border-t-blue-500 dark:border-gray-600 dark:border-t-blue-400"></div>
        </div>
        
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
          Completing authentication...
        </h2>
        
        <p class="text-sm text-gray-600 dark:text-gray-400">
          Please wait while we sign you in
        </p>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'AuthCallback',
  async mounted() {
    const urlParams = new URLSearchParams(window.location.search)
    const token = urlParams.get('token')
    const error = urlParams.get('error')
    
    if (error) {
      this.$router.push({ name: 'Login', query: { error: 'Authentication failed' } })
      return
    }
    
    if (token) {
      // Store token
      localStorage.setItem('auth_token', token)
      
      // Set default Authorization header for future requests
      axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
      
      // Verify token works by fetching user
      try {
        await axios.get('/api/user')
        this.$router.push('/dashboard')
      } catch (error) {
        localStorage.removeItem('auth_token')
        delete axios.defaults.headers.common['Authorization']
        this.$router.push({ name: 'Login', query: { error: 'Invalid token' } })
      }
    } else {
      this.$router.push({ name: 'Login', query: { error: 'No token received' } })
    }
  }
}
</script>