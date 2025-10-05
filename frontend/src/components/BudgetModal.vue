<template>
    <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center overflow-x-hidden overflow-y-auto bg-black/70 backdrop-blur-sm">
        <div class="relative p-4 w-full max-w-4xl max-h-full">
            <div class="relative bg-slate-800/60 backdrop-blur-md rounded-2xl shadow-2xl border border-gray-700/50 max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between p-6 border-b border-gray-700/50">
                    <h3 class="text-2xl font-bold text-white">
                        {{ props.id ? 'Edit Budget' : 'Create Budget' }}
                    </h3>
                    <button 
                        type="button" 
                        @click="close_modal"
                        class="text-gray-400 hover:bg-slate-700/50 hover:text-white rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center transition-colors">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>

                <div :class="{ 'disabled-div': loading }" class="p-6 space-y-6">
                    <form @submit.prevent="accept_action" class="space-y-6">
                        <div class="bg-slate-700/30 p-6 rounded-xl border border-gray-700/50">
                            <h4 class="text-lg font-semibold text-white mb-4">Budget Information</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="budget-name" class="block mb-2 text-sm font-medium text-gray-300">Budget Name</label>
                                    <input 
                                        type="text" 
                                        id="budget-name" 
                                        v-model="budget_data.budget_name"
                                        class="bg-slate-700/50 border border-gray-600 text-white text-sm rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-3 placeholder-gray-500 transition-all" 
                                        placeholder="Enter budget name"
                                        required>
                                </div>
                                
                                <div>
                                    <label for="status-select" class="block mb-2 text-sm font-medium text-gray-300">Select Status</label>
                                    <select 
                                        id="status-select" 
                                        v-model="budget_data.status_id"
                                        @change="update_status_name"
                                        class="bg-slate-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-3 transition-all [&>option]:bg-slate-800 [&>option]:text-white"
                                        required>
                                        <option value="" disabled class="bg-slate-800">Choose a status</option>
                                        <option 
                                            v-for="status in statuses" 
                                            :key="status.id" 
                                            :value="status.id"
                                            class="bg-slate-800">
                                            {{ status.name }}
                                        </option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="amount-to-budget" class="block mb-2 text-sm font-medium text-gray-300">Total Budget Amount</label>
                                    <input 
                                        type="number" 
                                        id="amount-to-budget" 
                                        v-model="budget_data.amount_to_budget"
                                        step="0.01"
                                        min="0"
                                        class="bg-slate-700/50 border border-gray-600 text-white text-sm rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-3 placeholder-gray-500 transition-all" 
                                        placeholder="Enter total budget amount"
                                        required>
                                </div>

                                <div>
                                    <label for="cutoff-type" class="block mb-2 text-sm font-medium text-gray-300">Cutoff Type</label>
                                    <select 
                                        id="cutoff-type" 
                                        v-model="budget_data.cutoff_type"
                                        @change="update_cutoff_type"
                                        class="bg-slate-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-3 transition-all [&>option]:bg-slate-800 [&>option]:text-white"
                                        required>
                                        <option value="" disabled class="bg-slate-800">Choose cutoff type</option>
                                        <option 
                                            v-for="type in cutoff_types" 
                                            :key="type.id" 
                                            :value="type.id"
                                            class="bg-slate-800">
                                            {{ type.name }}
                                        </option>
                                    </select>
                                </div>

                                <div>
                                    <label for="budget-date" class="block mb-2 text-sm font-medium text-gray-300">Budget Date</label>
                                    <input 
                                        type="date" 
                                        id="budget-date" 
                                        v-model="budget_data.budget_date"
                                        class="bg-slate-700/50 border border-gray-600 text-white text-sm rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-3 transition-all" 
                                        required>
                                </div>
                            </div>
                        </div>

                        <div class="bg-slate-700/30 p-6 rounded-xl border border-gray-700/50">
                            <div class="flex justify-between items-center mb-4">
                              <div class="flex justify-start items-center">
                                <h4 class="text-lg font-semibold text-white">Budget Details</h4>
                                <p class="ml-8 text-white text-xs">Remaining: {{ remaining_budget }}</p>
                              </div>
                                <button 
                                    type="button" 
                                    @click="add_budget_detail"
                                    class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 rounded-lg transition-all hover:scale-105 hover:shadow-lg hover:shadow-green-500/50">
                                    + Add Detail
                                </button>
                            </div>

                            <div v-if="budget_data.budget_details.length === 0" class="text-center py-8 text-gray-400">
                                <p>No budget details added yet. Click "Add Detail" to start.</p>
                            </div>

                            <div v-for="(detail, index) in budget_data.budget_details" :key="index" class="mb-4 p-5 border border-gray-600/50 rounded-xl bg-slate-800/40 backdrop-blur-sm">
                                <div class="flex justify-between items-center mb-4">
                                    <h5 class="text-md font-semibold text-white">Detail {{ index + 1 }}</h5>
                                    <button 
                                        type="button" 
                                        @click="remove_budget_detail(index)"
                                        class="text-red-400 hover:text-red-300 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4 pb-4">
                                    <label class="flex items-center p-3 rounded-lg bg-slate-700/30 border border-gray-600/50 cursor-pointer hover:border-blue-500/50 transition-all">
                                        <input 
                                            type="radio"
                                            value="Income"
                                            v-model="detail.type"
                                            class="w-4 h-4 text-blue-600 bg-slate-700 border-gray-600 focus:ring-blue-500 focus:ring-2"
                                        />
                                        <span class="ml-2 text-sm font-medium text-gray-300">Income</span>
                                    </label>
                                    <label class="flex items-center p-3 rounded-lg bg-slate-700/30 border border-gray-600/50 cursor-pointer hover:border-red-500/50 transition-all">
                                        <input 
                                            type="radio"
                                            value="Expense"
                                            v-model="detail.type"
                                            class="w-4 h-4 text-blue-600 bg-slate-700 border-gray-600 focus:ring-blue-500 focus:ring-2"
                                        />
                                        <span class="ml-2 text-sm font-medium text-gray-300">Expense</span>
                                    </label>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div v-if="detail.type == 'Income'">
                                        <label :for="`budget-type-${index}`" class="block mb-2 text-sm font-medium text-gray-300">Budget Type</label>
                                        <select 
                                            :id="`budget-type-${index}`"
                                            v-model="detail.budget_type_id"
                                            @change="update_budget_type(index)"
                                            class="bg-slate-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-3 transition-all [&>option]:bg-slate-800 [&>option]:text-white"
                                            required>
                                            <option value="" disabled class="bg-slate-800">Choose budget type</option>
                                            <option 
                                                v-for="type in income_budget_types" 
                                                :key="type.id" 
                                                :value="type.id"
                                                class="bg-slate-800">
                                                {{ type.name }}
                                            </option>
                                        </select>
                                    </div>

                                    <div v-else>
                                        <label :for="`budget-type-${index}`" class="block mb-2 text-sm font-medium text-gray-300">Budget Type</label>
                                        <select 
                                            :id="`budget-type-${index}`"
                                            v-model="detail.budget_type_id"
                                            @change="update_budget_type(index)"
                                            class="bg-slate-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-3 transition-all [&>option]:bg-slate-800 [&>option]:text-white"
                                            required>
                                            <option value="" disabled class="bg-slate-800">Choose budget type</option>
                                            <option 
                                                v-for="type in expense_budget_types" 
                                                :key="type.id" 
                                                :value="type.id"
                                                class="bg-slate-800">
                                                {{ type.name }}
                                            </option>
                                        </select>
                                    </div>

                                    <div>
                                        <label :for="`detail-amount-${index}`" class="block mb-2 text-sm font-medium text-gray-300">Amount</label>
                                        <input 
                                            type="number" 
                                            :id="`detail-amount-${index}`"
                                            v-model="detail.amount"
                                            step="0.01"
                                            min="0"
                                            class="bg-slate-700/50 border border-gray-600 text-white text-sm rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-3 placeholder-gray-500 transition-all" 
                                            placeholder="Enter amount"
                                            required
                                            @change="compute_remaining()"
                                          >
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <label :for="`detail-description-${index}`" class="block mb-2 text-sm font-medium text-gray-300">Description (Optional)</label>
                                    <textarea 
                                        :id="`detail-description-${index}`"
                                        v-model="detail.description"
                                        rows="2" 
                                        class="bg-slate-700/50 border border-gray-600 text-white text-sm rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-3 placeholder-gray-500 transition-all" 
                                        placeholder="Describe this budget detail..."></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div :class="{ 'disabled-div': loading }" class="flex items-center gap-3 p-6 border-t border-gray-700/50">
                    <button 
                        @click="accept_action" 
                        type="button" 
                        class="px-6 py-3 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 rounded-lg transition-all hover:scale-105 hover:shadow-lg hover:shadow-blue-500/50">
                        {{ props.id ? 'Update Budget' : 'Create Budget' }}
                    </button>
                    <button 
                        @click="decline_action" 
                        type="button" 
                        class="px-6 py-3 text-sm font-medium text-gray-300 bg-slate-700/50 hover:bg-slate-700 rounded-lg border border-gray-600 transition-all">
                        Cancel
                    </button>
                    <button 
                        v-if="props.id !== null"
                        @click="delete_budget" 
                        type="button" 
                        class="px-6 py-3 text-sm font-medium text-white bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 rounded-lg transition-all hover:scale-105 hover:shadow-lg hover:shadow-red-500/50 ml-auto">
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
const remaining_budget = ref(0);

watch(() => props.show, (newValue) => {
    get_statuses();
    get_cutoff_types();
    get_budget_types();

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
        const response = await axios.get('api/budget_types');
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

function compute_remaining() {
  remaining_budget.value = budget_data.value.amount_to_budget;
  for (let i in budget_data.value.budget_details) {
    let bd = budget_data.value.budget_details[i];
    remaining_budget.value -= bd.amount;
  }
}

function remove_budget_detail(index) {
    budget_data.value.budget_details.splice(index, 1);
    compute_remaining();
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