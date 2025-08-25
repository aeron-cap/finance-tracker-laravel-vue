<template>
  <div class="h-screen flex flex-col overflow-hidden">
    <!-- Navbar with proper sticky positioning -->
    <Disclosure as="nav" class="bg-gray-800 sticky top-0 z-50 flex-shrink-0" v-slot="{ open }">
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

    <!-- Main content area that fills remaining space -->
    <main class="flex-1 overflow-y-auto bg-gray-50 dark:bg-gray-900 pb-20">
      <RouterView />
    </main>

    <!-- Footer fixed at bottom -->
    <footer class="bg-white shadow-lg dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 z-10 flex-shrink-0">
      <div class="w-full mx-auto max-w-screen-xl p-4 md:flex md:items-center md:justify-between">
        
        <div v-if="$route.name === 'Budgets'" class="flex gap-2">
          <button 
            @click="create($route.name)" 
            :disabled="loading"
            class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-cyan-500 to-blue-500 group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800 disabled:opacity-50">
            <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-transparent group-hover:dark:bg-transparent">
                Create Budget
            </span>
          </button>
        </div>

        <div v-else-if="$route.name === 'Incomes'" class="flex gap-2">
          <button 
            @click="create($route.name)" 
            :disabled="loading"
            class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-green-400 to-green-600 group-hover:from-green-400 group-hover:to-green-600 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-800 disabled:opacity-50">
            <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-transparent group-hover:dark:bg-transparent">
                Add Income
            </span>
          </button>
        </div>

        <div v-else-if="$route.name === 'Expenses'" class="flex gap-2">
          <button 
            @click="create($route.name)" 
            :disabled="loading"
            class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-red-400 to-red-600 group-hover:from-red-400 group-hover:to-red-600 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-800 disabled:opacity-50">
            <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-transparent group-hover:dark:bg-transparent">
                Add Expense
            </span>
          </button>
        </div>

        <div v-else-if="$route.name === 'Accounts'" class="flex gap-2">
          <button 
            @click="create($route.name)" 
            :disabled="loading"
            class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-purple-400 to-purple-600 group-hover:from-purple-400 group-hover:to-purple-600 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-purple-200 dark:focus:ring-purple-800 disabled:opacity-50">
            <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-transparent group-hover:dark:bg-transparent">
                Add Account
            </span>
          </button>
        </div>

        <div v-else-if="$route.name === 'Investments'" class="flex gap-2">
          <button 
            @click="create($route.name)" 
            :disabled="loading"
            class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-yellow-400 to-yellow-600 group-hover:from-yellow-400 group-hover:to-yellow-600 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-yellow-200 dark:focus:ring-yellow-800 disabled:opacity-50">
            <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-transparent group-hover:dark:bg-transparent">
                Add Investment/Goal
            </span>
          </button>
        </div>

        <!-- Dashboard (Home) page footer - Multiple actions -->
        <!-- <div v-else-if="$route.name === 'Home'" class="flex gap-2 flex-wrap">
          <button 
            @click="quick_add_expense" 
            :disabled="loading"
            class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-red-400 to-red-600 group-hover:from-red-400 group-hover:to-red-600 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-800 disabled:opacity-50">
            <span class="relative px-4 py-2 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-transparent group-hover:dark:bg-transparent text-xs">
                Quick Expense
            </span>
          </button>
          <button 
            @click="quick_add_income" 
            :disabled="loading"
            class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-green-400 to-green-600 group-hover:from-green-400 group-hover:to-green-600 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-800 disabled:opacity-50">
            <span class="relative px-4 py-2 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-transparent group-hover:dark:bg-transparent text-xs">
                Quick Income
            </span>
          </button>
        </div> -->

        <div v-else class="flex justify-center">
          <span class="text-sm text-gray-500 dark:text-gray-400">
            {{ currentPageTitle }}
          </span>
        </div>
        
      </div>
      
      <!-- Modals -->
      <BudgetModal :show="showBudgetModal" :id=null @close="close($route.name)" @accept="close($route.name)" @decline="close($route.name)" />
      <IncomeModal :show="showIncomeModal" :id=null @close="close($route.name)" @accept="close($route.name)" @decline="close($route.name)" />
      <ExpenseModal :show="showExpenseModal" :id=null @close="close($route.name)" @accept="close($route.name)" @decline="close($route.name)" />
      <AccountModal :show="showAccountModal" :id=null @close="close($route.name)" @accept="close($route.name)" @decline="close($route.name)" />
    </footer>
  </div>
</template>

<script setup>
import { computed, ref } from 'vue';
import { useRoute } from 'vue-router';;
import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue'
import { Bars3Icon, XMarkIcon } from '@heroicons/vue/24/outline';
import BudgetModal from './BudgetModal.vue';
import IncomeModal from './IncomeModal.vue';
import ExpenseModal from './ExpenseModal.vue';
import AccountModal from './AccountModal.vue';

const route = useRoute();

const navigation = [
  { name: 'Dashboard', to: {name: 'Home'}},
  { name: 'Budgets', to: {name: 'Budgets'}},
  { name: 'Incomes', to: {name: 'Incomes'}},
  { name: 'Expenses', to: {name: 'Expenses'}},
  { name: 'Accounts', to: {name: 'Accounts'}},
  { name: 'Investments', to: {name: 'Investments'}},
];

const currentPageTitle = computed(() => {
  const currentNav = navigation.find(item => item.to.name === route.name)
  return currentNav ? currentNav.name : 'Home'
});

const loading = false;
const showBudgetModal = ref(false);
const showIncomeModal = ref(false);
const showExpenseModal = ref(false);
const showAccountModal = ref(false);
const showInvestmentModal = ref(false);

const create = (name) => {
  switch (name) {
    case "Budgets":
      showBudgetModal.value = true;
      break;
    case "Incomes":
      showIncomeModal.value = true;
      break;
    case "Expenses":
      showExpenseModal.value = true;
      break;
    case "Accounts":
      showAccountModal.value = true;
      break;
    case "Investments":
      showInvestmentModal.value = true;
      break;
    default:
      break;
  }
}

const close = (name) => {
  switch (name) {
    case "Budgets":
      showBudgetModal.value = false;
      break;
    case "Incomes":
      showIncomeModal.value = false;
      break;
    case "Expenses":
      showExpenseModal.value = false;
      break;
    case "Accounts":
      showAccountModal.value = false;
      break;
    case "Investments":
      showInvestmentModal.value = false;
      break;
    default:
      break;
  }
}

const quick_add_expense = () => {
  showExpenseModal.value = true;
}

const quick_add_income = () => {
  showIncomeModal.value = true;
}

</script>

<style lang="scss" scoped>
</style>