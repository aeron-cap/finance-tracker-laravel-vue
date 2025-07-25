<template>
  <div>
    <!-- Navbar with proper sticky positioning -->
    <Disclosure as="nav" class="bg-gray-800 sticky top-0 z-50" v-slot="{ open }">
      <div class="mx-auto max-w-7xl px-1 sm:px-6 lg:px-8">
        <div class="relative flex h-16 items-center justify-between">
          <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
            <!-- Mobile menu button-->
            <DisclosureButton class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:ring-2 focus:ring-white focus:outline-hidden focus:ring-inset">
              <span class="absolute -inset-0.5" />
              <span class="sr-only">Open main menu</span>
              <Bars3Icon v-if="!open" class="block size-6" aria-hidden="true" />
              <XMarkIcon v-else class="block size-6" aria-hidden="true" />
            </DisclosureButton>
          </div>
          <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
            <!-- Uncomment if you want to add a logo -->
            <!-- <div class="flex shrink-0 items-center">
              <img class="h-8 w-auto" src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500" alt="Your Company" />
            </div> -->
            <div class="hidden sm:ml-6 sm:block">
              <div class="flex space-x-4">
                  <RouterLink 
                  v-for="item in navigation" 
                  :key="item.name" 
                  :to="item.to" 
                  :class="[$route.name === item.to.name ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'rounded-md px-3 py-2 text-sm font-medium']" 
                  :aria-current="$route.name === item.to.name ? 'page' : undefined">
                      {{ item.name }}
                  </RouterLink>
              </div>
            </div>
          </div>
        </div>
      </div>

      <DisclosurePanel class="sm:hidden bg-gray-800">
        <div class="space-y-1 px-2 pt-2 pb-3">
          <RouterLink 
          v-for="item in navigation" 
          :key="item.name" 
          as="a" 
          :to="item.to" 
          :class="[$route.name === item.to.name ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'block rounded-md px-3 py-2 text-base font-medium']" 
          :aria-current="$route.name === item.to.name ? 'page' : undefined">
              {{ item.name }}
          </RouterLink>
        </div>
      </DisclosurePanel>
    </Disclosure>

    <!-- Content area with top padding to account for sticky navbar -->
    <main class="pt-0">
      <RouterView />
    </main>
  </div>
</template>

<script setup>
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { Bars3Icon, BellIcon, XMarkIcon } from '@heroicons/vue/24/outline'

const navigation = [
  { name: 'Dashboard', to: {name: 'Home'}},
  { name: 'Budgets', to: {name: 'Budgets'}},
  { name: 'Investments', to: {name: 'Investments'}},
  { name: 'Accounts', to: {name: 'Accounts'}},
]
</script>

<style lang="scss" scoped>
</style>