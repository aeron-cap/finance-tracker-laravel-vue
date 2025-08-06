<template>
    <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center overflow-x-hidden overflow-y-auto bg-black bg-opacity-50">
        <div class="relative p-4 w-full max-w-4xl max-h-full">
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700 max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Create Budget
                    </h3>
                    <button 
                        type="button" 
                        @click="close_modal"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div :class="{ 'disabled-div': loading }" class="p-4 md:p-5 space-y-6">
                    <form @submit.prevent="accept_action" class="space-y-6">
                        <!-- Budget Information Section -->
                        <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                            <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Budget Information</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="budget-name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Budget Name</label>
                                    <input 
                                        type="text" 
                                        id="budget-name" 
                                        v-model="budget_data.budget_name"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                        placeholder="Enter budget name"
                                        required>
                                </div>
                                
                                <div>
                                    <label for="status-select" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Status</label>
                                    <select 
                                        id="status-select" 
                                        v-model="budget_data.status_id"
                                        @change="update_status_name"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        required>
                                        <option value="" disabled>Choose a status</option>
                                        <option 
                                            v-for="status in statuses" 
                                            :key="status.id" 
                                            :value="status.id">
                                            {{ status.name }}
                                        </option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="amount-to-budget" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Total Budget Amount</label>
                                    <input 
                                        type="number" 
                                        id="amount-to-budget" 
                                        v-model="budget_data.amount_to_budget"
                                        step="0.01"
                                        min="0"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                        placeholder="Enter total budget amount"
                                        required>
                                </div>

                                <div>
                                    <label for="cutoff-type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cutoff Type</label>
                                    <select 
                                        id="cutoff-type" 
                                        v-model="budget_data.cutoff_type"
                                        @change="update_cutoff_type"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        required>
                                        <option value="" disabled>Choose cutoff type</option>
                                        <option 
                                            v-for="type in cutoff_types" 
                                            :key="type.id" 
                                            :value="type.id">
                                            {{ type.name }}
                                        </option>
                                    </select>
                                </div>

                                <div>
                                    <label for="budget-date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Budget Date</label>
                                    <input 
                                        type="date" 
                                        id="budget-date" 
                                        v-model="budget_data.budget_date"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                        required>
                                </div>
                            </div>
                        </div>

                        <!-- Budget Details Section -->
                        <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="text-lg font-medium text-gray-900 dark:text-white">Budget Details</h4>
                                <button 
                                    type="button" 
                                    @click="add_budget_detail"
                                    class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-3 py-2 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                    + Add Detail
                                </button>
                            </div>

                            <div v-if="budget_data.budget_details.length === 0" class="text-center py-8 text-gray-500 dark:text-gray-400">
                                <p>No budget details added yet. Click "Add Detail" to start.</p>
                            </div>

                            <div v-for="(detail, index) in budget_data.budget_details" :key="index" class="mb-4 p-4 border border-gray-200 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700">
                                <div class="flex justify-between items-center mb-3">
                                    <h5 class="text-md font-medium text-gray-900 dark:text-white">Detail {{ index + 1 }}</h5>
                                    <button 
                                        type="button" 
                                        @click="remove_budget_detail(index)"
                                        class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                                
                                <div class="grid grid-cols-2 pb-4">
                                    <div>
                                        <label class="flex items-center">
                                        <input 
                                            type="radio"
                                            value="Income"
                                            v-model="detail.type"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                        />
                                        <span class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Income</span>
                                        </label>
                                    </div>
                                    <div>
                                        <label class="flex items-center">
                                        <input 
                                            type="radio"
                                            value="Expense"
                                            v-model="detail.type"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                        />
                                        <span class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Expense</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div v-if= "detail.type == 'Income'">
                                        <label :for="`budget-type-${index}`" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Budget Type</label>
                                        <select 
                                            :id="`budget-type-${index}`"
                                            v-model="detail.budget_type_id"
                                            @change="update_budget_type(index)"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            required>
                                            <option value="" disabled>Choose budget type</option>
                                            <option 
                                                v-for="type in income_budget_types" 
                                                :key="type.id" 
                                                :value="type.id">
                                                {{ type.name }}
                                            </option>
                                        </select>
                                    </div>

                                    <div v-else>
                                        <label :for="`budget-type-${index}`" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Budget Type</label>
                                        <select 
                                            :id="`budget-type-${index}`"
                                            v-model="detail.budget_type_id"
                                            @change="update_budget_type(index)"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            required>
                                            <option value="" disabled>Choose budget type</option>
                                            <option 
                                                v-for="type in expense_budget_types" 
                                                :key="type.id" 
                                                :value="type.id">
                                                {{ type.name }}
                                            </option>
                                        </select>
                                    </div>

                                    <div>
                                        <label :for="`detail-amount-${index}`" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Amount</label>
                                        <input 
                                            type="number" 
                                            :id="`detail-amount-${index}`"
                                            v-model="detail.amount"
                                            step="0.01"
                                            min="0"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                            placeholder="Enter amount"
                                            required>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <label :for="`detail-description-${index}`" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description (Optional)</label>
                                    <textarea 
                                        :id="`detail-description-${index}`"
                                        v-model="detail.description"
                                        rows="2" 
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                        placeholder="Describe this budget detail..."></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div :class="{ 'disabled-div': loading }" class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button 
                        @click="accept_action" 
                        type="button" 
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Create Budget
                    </button>
                    <button 
                        @click="decline_action" 
                        type="button" 
                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                        Cancel
                    </button>
                    <button 
                        v-if="props.id !== null"
                        @click="delete_budget" 
                        type="button" 
                        class="py-2.5 px-5 ms-3 text-sm font-medium text-red-900 focus:outline-none bg-white rounded-lg border border-red-200 hover:bg-gray-100 hover:text-red-700 focus:z-10 focus:ring-4 focus:ring-red-100 dark:focus:ring-red-700 dark:bg-red-800 dark:text-red-400 dark:border-red-600 dark:hover:text-white dark:hover:bg-red-700">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref, watch } from 'vue';
import axios from '../lib/axios';

onMounted(() => {
    get_statuses();
    get_cutoff_types();
    get_budget_types();
});

const props = defineProps({
    show: {
        type: Boolean,
        default: false
    },
    id: {
        type: Number,
        default: null,
    }
});

const emit = defineEmits(['close', 'accept', 'decline']);

const budget_data = ref({
    status_id: null,
    status_name: '',
    budget_name: '',
    amount_to_budget: '',
    cutoff_type: null,
    cutoff_type_name: '',
    budget_date: '',
    budget_details: [],
});

const statuses = ref([]);
const cutoff_types = ref([]);
const income_budget_types = ref([]);
const expense_budget_types = ref([]);
const loading = ref(false);

watch(() => props.show, (newValue) => {
    if (!newValue || props.id == null) {
        budget_data.value.status_id = null;
        budget_data.value.status_name = '';
        budget_data.value.budget_name = '';
        budget_data.value.amount_to_budget = '';
        budget_data.value.cutoff_type = null;
        budget_data.value.cutoff_type_name = '';
        budget_data.value.budget_date = new Date().toISOString().slice(0, 10);
        budget_data.value.budget_details = [];
    }

    if (props.id > 0) {
        get_budget_types();
        get_budget_data(props.id);
    }
});

async function get_budget_data(id){
  loading.value = true;
    try {
        const response = await axios.get(`api/budget/${id}`);
        let budget_from_db = response.data.budget || [];

        if (Object.keys(budget_from_db).length > 0) {
            set_budget_data(budget_from_db);
        }

    } catch (error) {
        console.error('Error fetching statuses:', error);
    }
  loading.value = false;
}

function set_budget_data(data) {
    budget_data.value.status_id = data.status_id;
    budget_data.value.status_name = data.status_name;
    budget_data.value.budget_name = data.budget_name;
    budget_data.value.amount_to_budget = data.amount_to_budget;
    budget_data.value.cutoff_type = data.cutoff_type;
    budget_data.value.cutoff_type_name = data.cutoff_type_name;
    budget_data.value.budget_date = data.budget_date;
    budget_data.value.budget_details = data.budget_details;

    for (let i = 0; i < budget_data.value.budget_details.length; i++) {
        filter_detail_type_dropdown(i);
        update_budget_type(i);
    }

    budget_data.value.type = data.type;
}

async function get_statuses() {
    try {
        const response = await axios.get('api/statuses');
        statuses.value = response.data.status || [];
    } catch (error) {}
}

async function get_cutoff_types() {
    try {
        const response = await axios.get('api/cutoff_types');
        cutoff_types.value = response.data.cutoff_types || [];
    } catch (error) {}
}

async function get_budget_types() {
    try {
        const response = await axios.post('api/budget_types');
        income_budget_types.value = (response.data.budget_types || []).filter(type => type.type === "Income");
        expense_budget_types.value = (response.data.budget_types || []).filter(type => type.type === "Expense");
    } catch (error) {}
}

function update_status_name() {
    const selectedStatus = statuses.value.find(status => status.id === budget_data.value.status_id);
    if (selectedStatus) {
        budget_data.value.status_name = selectedStatus.name;
    }
}

function update_cutoff_type() {
    const selectedCutoffType = cutoff_types.value.find(cutoff_type => cutoff_type.id === budget_data.value.cutoff_type);
    if (selectedCutoffType) {
        budget_data.value.cutoff_type_name = selectedCutoffType.name;
    }
}

function update_budget_type(index) {
    let selectedType = null;

    if (budget_data.value.budget_details[index].type == "Income") {
        selectedType = income_budget_types.value.find(type => type.id === budget_data.value.budget_details[index].budget_type_id);
    } else {
        selectedType = expense_budget_types.value.find(type => type.id === budget_data.value.budget_details[index].budget_type_id);
    }

    if (selectedType) {
        budget_data.value.budget_details[index].budget_type_name = selectedType.name;
    }
}

function filter_detail_type_dropdown(index) {
    let type = budget_data.value.budget_details[index].type;
    budget_data.value.budget_details[index].budget_types = budget_types.value.filter(j => j.type === type);
}

function add_budget_detail() {
    budget_data.value.budget_details.push({
        budget_type_id: null,
        budget_type_name: '',
        description: '',
        amount: '',
        is_used: false,
        type: ''
    });
}

function remove_budget_detail(index) {
    budget_data.value.budget_details.splice(index, 1);
}

function delete_budget() {
    if(props.id > 0) {
        try {
            axios.post(`/api/budget-delete/${props.id}`, budget_data.value).then((response) => {
                close_modal();
            });
        } catch (err) {}
    }
}

function accept_action() {
  loading.value = true;
    if (!budget_data.value.budget_name || !budget_data.value.status_id || !budget_data.value.amount_to_budget || !budget_data.value.cutoff_type || !budget_data.value.budget_date) {
        alert('Please fill in all required budget fields');
        return;
    }

    for (let i = 0; i < budget_data.value.budget_details.length; i++) {
        const detail = budget_data.value.budget_details[i];
        if (!detail.budget_type_id || !detail.amount) {
            alert(`Please fill in all required fields for Budget Detail ${i + 1}`);
            return;
        }
    }

    if(props.id > 0) {
        try {
            axios.post(`/api/budget/${props.id}`, budget_data.value).then((response) => {
                console.log(response);

                emit('accept', {
                    ...budget_data.value,
                });
            });
        } catch (err) {}
    } else {
        try {
            axios.post('/api/budget', budget_data.value).then((response) => {
                console.log(response);

                emit('accept', {
                    ...budget_data.value,
                });
            });
        } catch (err) {}
    }
  loading.value = false;
}

function decline_action() {
    emit('decline');
}

function close_modal() {
    emit('close');
}

</script>

<style scoped>
  .disabled-div {
    opacity: 0.5;
    pointer-events: none;
  }
</style>