<template>
    <div class="h-fit bg-gray-50 dark:bg-gray-900 pb-20">
          <div class="h-full px-4 py-6 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Accounts</h1>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    Manage your Accounts
                </p>
            </div>

            <div v-if="loading" class="flex justify-center items-center py-8">
                <div role="status">
                    <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C0 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                    </svg>
                    <span class="sr-only">Loading...</span>
                </div>
            </div>

            <div v-else-if="error" class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mx-4 my-4">
                <strong>Error:</strong> {{ error }}
            </div>

            <div v-else class="relative overflow-x-auto overflow-y-auto">
                <div v-if="accounts_data.length === 0" class="place-items-center pt-6 pb-6">
                    <div>
                        <span class="px-6 py-4 text-center text-gray-500"> No accounts found </span>
                    </div>
                </div>
                <div class="grid pt-6 pb-6 grid-cols-1 md:grid-cols-2 gap-4">
                  <div v-for="(account, index) in accounts_data" class="w-full h-auto rounded-lg">
                    <div class="w-full p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                      <a>
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                          {{ account.name }}
                        </h5>
                      </a>
                      <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                        {{ account.description }}
                      </p>
                      <button
                        @click="edit_account(account.id)"
                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        type="button"
                      >
                        Edit
                      </button>
                    </div>
                  </div>
                </div>
            </div>
        </div>

        <footer class="fixed bottom-0 left-0 right-0 bg-white shadow-lg dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 z-10">
            <div class="w-full mx-auto max-w-screen-xl p-4 md:flex md:items-center md:justify-between">
                <button 
                    @click="create_account" 
                    :disabled="loading"
                    class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-cyan-500 to-blue-500 group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800 disabled:opacity-50">
                    <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-transparent group-hover:dark:bg-transparent">
                        Create Account
                    </span>
                </button>
            </div>
        </footer>
    </div>

    <AccountModal :show="showModal" :id="account_id" @close="close_modal" @accept="handle_accept" @decline="handle_decline" />
</template>

<script setup>
import { onMounted, ref } from 'vue';
import axios from '../lib/axios';
import AccountModal from '../components/AccountModal.vue';

const accounts_data = ref([]);
const loading = ref(false);
const error = ref(null);
const showModal = ref(false);
const account_id = ref(false);

onMounted(() => {
    get_all_accounts();
});

async function get_all_accounts() {
    loading.value = true;
    error.value = null;

    try {
        const response = await axios.post('api/accounts');
        accounts_data.value = response.data.accounts || [];
    } catch (err) {
        error.value = err.response?.data?.message || err.message || 'Failed to load accounts';
    }
    finally{
        loading.value = false;
    }
}

function create_account() {
    account_id.value = null;
    showModal.value = true;
}

function close_modal() {
    showModal.value = false;
    get_all_accounts();
}

function handle_decline() {
    close_modal();
}

function handle_accept() {
  showModal.value = false;
  get_all_accounts();
}

function edit_account(id) {
  account_id.value = id;
  showModal.value = true;
}

</script>

<style lang="scss" scoped>

</style>