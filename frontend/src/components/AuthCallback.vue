<template>
  <div class="flex justify-center items-center min-h-screen">
    <div class="text-center">
      <div class="animate-spin rounded-full h-32 w-32 border-b-2 border-gray-900 mx-auto"></div>
      <p class="mt-4">Completing authentication...</p>
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