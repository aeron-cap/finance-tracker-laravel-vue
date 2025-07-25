<template>
    <main>
        <header class="bg-white shadow">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <h1 class="text-2xl/7 font-bold text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                    Accounts
                </h1>
            </div>
        </header>
        <div class="mt-5 flex lg:mt-0 lg:ml-4">
        <!-- <span class="hidden sm:block">
            <button type="button" class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-xs ring-1 ring-gray-300 ring-inset hover:bg-gray-50">
            <PencilIcon class="mr-1.5 -ml-0.5 size-5 text-gray-400" aria-hidden="true" />
            Edit
            </button>
        </span>

        <span class="ml-3 hidden sm:block">
            <button type="button" class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-xs ring-1 ring-gray-300 ring-inset hover:bg-gray-50">
            <LinkIcon class="mr-1.5 -ml-0.5 size-5 text-gray-400" aria-hidden="true" />
            View
            </button>
        </span>

        <span class="sm:ml-3">
            <button type="button" class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
            <CheckIcon class="mr-1.5 -ml-0.5 size-5" aria-hidden="true" />
            Publish
            </button>
        </span> -->

        <!-- Dropdown -->
        <!-- <Menu as="div" class="relative ml-3 sm:hidden">
            <MenuButton class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-xs ring-1 ring-gray-300 ring-inset hover:ring-gray-400">
            More
            <ChevronDownIcon class="-mr-1 ml-1.5 size-5 text-gray-400" aria-hidden="true" />
            </MenuButton>

            <transition enter-active-class="transition ease-out duration-200" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
            <MenuItems class="absolute left-0 z-10 mt-2 -mr-1 w-24 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black/5 focus:outline-hidden">
                <MenuItem v-slot="{ active }">
                <a href="#" :class="[active ? 'bg-gray-100 outline-hidden' : '', 'block px-4 py-2 text-sm text-gray-700']">Edit</a>
                </MenuItem>
                <MenuItem v-slot="{ active }">
                <a href="#" :class="[active ? 'bg-gray-100 outline-hidden' : '', 'block px-4 py-2 text-sm text-gray-700']">View</a>
                </MenuItem>
            </MenuItems>
            </transition>
        </Menu> -->
        </div>
    </main>
</template>

<script setup>
import {
  BriefcaseIcon,
  CalendarIcon,
  CheckIcon,
  ChevronDownIcon,
  CurrencyDollarIcon,
  LinkIcon,
  MapPinIcon,
  PencilIcon,
} from '@heroicons/vue/20/solid'
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
</script>

<style lang="scss" scoped>

</style>