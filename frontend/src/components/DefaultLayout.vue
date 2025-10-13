<template>
  <div class="h-screen flex flex-col overflow-hidden bg-slate-900">
    <div class="gradient-orb-1 fixed top-0 left-1/4 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="gradient-orb-2 fixed bottom-0 right-1/4 w-96 h-96 bg-purple-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="gradient-orb-3 fixed top-1/2 left-1/2 w-72 h-72 bg-pink-500/10 rounded-full blur-3xl pointer-events-none"></div>

    <Disclosure as="nav" class="sticky top-0 z-50 flex-shrink-0" v-slot="{ open }">
      <div class="mx-4 mt-4">
        <div class="max-w-7xl mx-auto rounded-2xl border border-white/10 backdrop-blur-md bg-slate-900/80 shadow-2xl shadow-blue-500/10">
          <div class="px-4 sm:px-6 lg:px-8">
            <div class="relative flex h-16 items-center justify-between">
              <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">

                <DisclosureButton class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-slate-700/50 hover:text-white focus:ring-2 focus:ring-blue-500 focus:outline-hidden transition-colors">
                  <span class="absolute -inset-0.5" />
                  <span class="sr-only">Open main menu</span>
                  <Bars3Icon v-if="!open" class="block size-6" aria-hidden="true" />
                  <XMarkIcon v-else class="block size-6" aria-hidden="true" />
                </DisclosureButton>
              </div>
              
              <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                <!-- logo here -->
                <div class="flex shrink-0 items-center mr-8">
                  <h1 class="text-2xl font-extrabold bg-gradient-to-r from-blue-500 to-purple-500 bg-clip-text text-transparent">
                    Finance++
                  </h1>
                </div>
                
                <div class="hidden sm:block">
                  <div class="flex space-x-2">
                    <RouterLink 
                      v-for="item in navigation" 
                      :key="item.name" 
                      :to="item.to" 
                      :class="[
                        $route.name === item.to.name 
                          ? 'bg-slate-700/70 text-white border-blue-500/50' 
                          : 'text-gray-300 hover:bg-slate-700/50 hover:text-white border-transparent', 
                        'rounded-lg px-4 py-2 text-sm font-medium transition-all duration-200 border'
                      ]" 
                      :aria-current="$route.name === item.to.name ? 'page' : undefined"
                    >
                      {{ item.name }}
                    </RouterLink>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <DisclosurePanel class="sm:hidden">
            <div class="space-y-1 px-4 pt-2 pb-3">
              <RouterLink 
                v-for="item in navigation" 
                :key="item.name" 
                as="a" 
                :to="item.to" 
                :class="[
                  $route.name === item.to.name 
                    ? 'bg-slate-700/70 text-white' 
                    : 'text-gray-300 hover:bg-slate-700/50 hover:text-white', 
                  'block rounded-lg px-3 py-2 text-base font-medium transition-colors'
                ]" 
                :aria-current="$route.name === item.to.name ? 'page' : undefined"
              >
                {{ item.name }}
              </RouterLink>
            </div>
          </DisclosurePanel>
        </div>
      </div>
    </Disclosure>

    <main class="flex-1 overflow-y-auto pb-20 relative z-10">
      <RouterView />
    </main>

    <footer class="z-20 flex-shrink-0 px-4 pb-4">
      <div class="max-w-7xl mx-auto rounded-2xl border border-white/10 backdrop-blur-md bg-slate-900/80 shadow-2xl shadow-blue-500/10">
        <div class="w-full p-4 flex items-center justify-center sm:justify-start lg:justify-start">
          
          <div v-if="$route.name === 'Budgets'" class="flex gap-2">
            <button 
              @click="create($route.name)" 
              :disabled="loading"
              class="relative px-6 py-3 rounded-lg text-sm font-medium text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600 hover:shadow-lg hover:shadow-cyan-500/50 transition-all duration-300 hover:scale-105 active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed"
            >
              Create Budget
            </button>
          </div>

          <div v-else-if="$route.name === 'Incomes'" class="flex gap-2">
            <button 
              @click="create($route.name)" 
              :disabled="loading"
              class="relative px-6 py-3 rounded-lg text-sm font-medium text-white bg-gradient-to-r from-green-400 to-green-600 hover:from-green-500 hover:to-green-700 hover:shadow-lg hover:shadow-green-500/50 transition-all duration-300 hover:scale-105 active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed"
            >
              Add Income
            </button>
          </div>

          <div v-else-if="$route.name === 'Expenses'" class="flex gap-2">
            <button 
              @click="create($route.name)" 
              :disabled="loading"
              class="relative px-6 py-3 rounded-lg text-sm font-medium text-white bg-gradient-to-r from-red-400 to-red-600 hover:from-red-500 hover:to-red-700 hover:shadow-lg hover:shadow-red-500/50 transition-all duration-300 hover:scale-105 active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed"
            >
              Add Expense
            </button>
          </div>

          <div v-else-if="$route.name === 'Accounts'" class="flex gap-2">
            <button 
              @click="create($route.name)" 
              :disabled="loading"
              class="relative px-6 py-3 rounded-lg text-sm font-medium text-white bg-gradient-to-r from-purple-400 to-purple-600 hover:from-purple-500 hover:to-purple-700 hover:shadow-lg hover:shadow-purple-500/50 transition-all duration-300 hover:scale-105 active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed"
            >
              Add Account
            </button>
          </div>

          <div v-else-if="$route.name === 'Investments'" class="flex gap-2">
            <button 
              @click="create($route.name)" 
              :disabled="loading"
              class="relative px-6 py-3 rounded-lg text-sm font-medium text-white bg-gradient-to-r from-yellow-400 to-yellow-600 hover:from-yellow-500 hover:to-yellow-700 hover:shadow-lg hover:shadow-yellow-500/50 transition-all duration-300 hover:scale-105 active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed"
            >
              Add Investment/Goal
            </button>
          </div>

        </div>
      </div>
    </footer>
    
    <BudgetModal :show="showBudgetModal" :id=null @close="close($route.name, 'close')" @accept="close($route.name, 'save')" @decline="close($route.name, 'close')" />
    <IncomeModal :show="showIncomeModal" :id=null @close="close($route.name, 'close')" @accept="close($route.name, 'save')" @decline="close($route.name, 'close')" />
    <ExpenseModal :show="showExpenseModal" :id=null @close="close($route.name, 'close')" @accept="close($route.name, 'save')" @decline="close($route.name, 'close')" />
    <AccountModal :show="showAccountModal" :id=null @close="close($route.name, 'close')" @accept="close($route.name, 'save')" @decline="close($route.name, 'close')" />
  </div>
</template>

<script setup>
  import { computed, ref } from 'vue';
  import { useRoute } from 'vue-router';
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
    // { name: 'Investments', to: {name: 'Investments'}},
    // Add Saving Goals new module
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

  const close = (name, type) => {
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

    if (type == "save") {
      location.reload(true);
    }
  }

  const quick_add_expense = () => {
    showExpenseModal.value = true;
  }

  const quick_add_income = () => {
    showIncomeModal.value = true;
  }
</script>

<style scoped>

</style>