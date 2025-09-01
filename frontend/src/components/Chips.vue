<template>
  <div class="multi-select-chips">
    <label v-if="label" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
      {{ label }}
    </label>
    <div class="relative" @click.stop>
      <div 
        @click="toggleDropdown"
        class="bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg p-2.5 cursor-pointer hover:border-blue-500 dark:hover:border-blue-500 transition-colors duration-200 min-h-[42px]"
        :class="{ 'border-blue-500 dark:border-blue-500': isDropdownOpen }"
      >

        <div v-if="selectedItems.length > 0" class="flex flex-wrap gap-2 mb-2">
          <span 
            v-for="selected in selectedItems" 
            :key="getItemValue(selected)"
            class="inline-flex items-center px-2.5 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300 hover:bg-blue-200 dark:hover:bg-blue-800 transition-all duration-200"
          >
            <span v-if="chipIcon" class="w-2 h-2 rounded-full mr-2" 
                  :class="getChipColor(selected)"></span>
            {{ getItemLabel(selected) }}
            <button 
              @click.stop="removeSelection(selected)"
              class="ml-1.5 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200"
            >
              <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </span>
        </div>
        
        <div 
          v-if="selectedItems.length === 0" 
          class="text-gray-500 dark:text-gray-400 text-sm"
        >
          {{ placeholder }}
        </div>
        
        <div class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
          <svg 
            class="w-4 h-4 text-gray-400 transition-transform duration-200" 
            :class="{ 'rotate-180': isDropdownOpen }"
            fill="none" 
            stroke="currentColor" 
            viewBox="0 0 24 24"
          >
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
          </svg>
        </div>
      </div>

      <transition name="dropdown">
        <div 
          v-if="isDropdownOpen"
          class="absolute z-10 w-full mt-1 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-lg max-h-64 overflow-hidden"
        >

          <div v-if="searchable" class="p-3 border-b border-gray-200 dark:border-gray-600">
            <input
              v-model="searchQuery"
              type="text"
              :placeholder="searchPlaceholder"
              class="w-full px-3 py-2 text-sm bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              @click.stop
            />
          </div>
          
          <div class="max-h-48 overflow-y-auto">
            <div 
              v-for="item in filteredItems" 
              :key="getItemValue(item)"
              @click="toggleSelection(item)"
              class="flex items-center px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-600 cursor-pointer transition-colors duration-150"
              :class="{ 'bg-blue-50 dark:bg-blue-900/20': isSelected(item) }"
            >
              
              <div class="flex-1">
                <span class="inline-flex items-center px-2.5 py-1.5 text-sm font-medium rounded-lg transition-colors duration-200"
                      :class="isSelected(item) 
                        ? 'text-blue-800 bg-blue-100 dark:bg-blue-900 dark:text-blue-300' 
                        : 'text-gray-700 bg-gray-100 dark:bg-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-500'"
                >
                  <span v-if="chipIcon" class="w-2 h-2 rounded-full mr-2" 
                        :class="getChipColor(item)"></span>
                  {{ getItemLabel(item) }}
                  <span v-if="getItemDescription(item)" 
                        class="ml-2 text-xs opacity-70">
                    {{ getItemDescription(item) }}
                  </span>
                </span>
              </div>
            </div>
            
            <div v-if="filteredItems.length === 0" 
                 class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
              {{ noResultsText }}
            </div>
          </div>
          
          <div v-if="showSelectAll && filteredItems.length > 0" 
               class="p-3 border-t border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-800">
            <div class="flex justify-between items-center">
              <button 
                @click="selectAll"
                class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200 underline"
              >
                Select All ({{ filteredItems.length }})
              </button>
              <button 
                v-if="selectedItems.length > 0"
                @click="clearAll"
                class="text-sm text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 underline"
              >
                Clear All
              </button>
            </div>
          </div>
        </div>
      </transition>
    </div>

    <div v-if="showSummary && selectedItems.length > 0" 
         class="mt-2 text-sm text-gray-600 dark:text-gray-400">
      {{ selectedItems.length }} item{{ selectedItems.length !== 1 ? 's' : '' }} selected
    </div>
  </div>
</template>

<script>
import { ref, computed, onMounted, onUnmounted, watch } from 'vue'

export default {
  name: 'MultiSelectChips',
  props: {
    items: {
      type: Array,
      required: true,
      default: () => []
    },
    modelValue: {
      type: Array,
      default: () => []
    },
    
    valueKey: {
      type: String,
      default: 'id'
    },
    labelKey: {
      type: String,
      default: 'name'
    },
    descriptionKey: {
      type: String,
      default: 'description'
    },
    colorKey: {
      type: String,
      default: 'color'
    },
    
    label: {
      type: String,
      default: ''
    },
    placeholder: {
      type: String,
      default: 'Choose items...'
    },
    searchPlaceholder: {
      type: String,
      default: 'Search items...'
    },
    noResultsText: {
      type: String,
      default: 'No items found'
    },
    
    searchable: {
      type: Boolean,
      default: true
    },
    showCheckbox: {
      type: Boolean,
      default: true
    },
    showSelectAll: {
      type: Boolean,
      default: true
    },
    showSummary: {
      type: Boolean,
      default: false
    },
    chipIcon: {
      type: Boolean,
      default: false
    },
    
    searchKeys: {
      type: Array,
      default: () => ['name', 'description'] 
    },
    
    colorOptions: {
      type: Object,
      default: () => ({
        primary: 'bg-blue-400',
        secondary: 'bg-gray-400',
        success: 'bg-green-400',
        warning: 'bg-yellow-400',
        danger: 'bg-red-400',
        info: 'bg-cyan-400',
        purple: 'bg-purple-400',
        pink: 'bg-pink-400'
      })
    }
  },
  emits: ['update:modelValue', 'change', 'select', 'deselect'],
  setup(props, { emit }) {
    const isDropdownOpen = ref(false)
    const searchQuery = ref('')
    const selectedItems = ref([])

    const filteredItems = computed(() => {
      if (!props.searchable || !searchQuery.value) return props.items
      
      const query = searchQuery.value.toLowerCase()
      return props.items.filter(item => {
        return props.searchKeys.some(key => {
          const value = getNestedValue(item, key)
          return value && value.toString().toLowerCase().includes(query)
        })
      })
    })

    const getNestedValue = (obj, key) => {
      return key.split('.').reduce((o, k) => o && o[k], obj)
    }

    const getItemValue = (item) => {
      return getNestedValue(item, props.valueKey)
    }

    const getItemLabel = (item) => {
      return getNestedValue(item, props.labelKey) || 'Unknown'
    }

    const getItemDescription = (item) => {
      return props.descriptionKey ? getNestedValue(item, props.descriptionKey) : null
    }

    const getChipColor = (item) => {
      if (!props.chipIcon) return ''
      
      const colorValue = getNestedValue(item, props.colorKey)
      if (colorValue && props.colorOptions[colorValue]) {
        return props.colorOptions[colorValue]
      }
      
      const colors = Object.values(props.colorOptions)
      const hash = getItemValue(item).toString().split('').reduce((a, b) => {
        a = ((a << 5) - a) + b.charCodeAt(0)
        return a & a
      }, 0)
      return colors[Math.abs(hash) % colors.length]
    }

    const toggleDropdown = () => {
      isDropdownOpen.value = !isDropdownOpen.value
      if (isDropdownOpen.value) {
        searchQuery.value = ''
      }
    }

    const closeDropdown = () => {
      isDropdownOpen.value = false
    }

    const isSelected = (item) => {
      const itemValue = getItemValue(item)
      return selectedItems.value.some(selected => getItemValue(selected) === itemValue)
    }

    const toggleSelection = (item) => {
      const itemValue = getItemValue(item)
      const index = selectedItems.value.findIndex(selected => getItemValue(selected) === itemValue)
      
      if (index > -1) {
        selectedItems.value.splice(index, 1)
        emit('deselect', item)
      } else {
        selectedItems.value.push(item)
        emit('select', item)
      }
      
      updateModel()
    }

    const removeSelection = (item) => {
      const itemValue = getItemValue(item)
      const index = selectedItems.value.findIndex(selected => getItemValue(selected) === itemValue)
      
      if (index > -1) {
        selectedItems.value.splice(index, 1)
        emit('deselect', item)
        updateModel()
      }
    }

    const selectAll = () => {
      const newSelections = filteredItems.value.filter(item => !isSelected(item))
      selectedItems.value.push(...newSelections)
      newSelections.forEach(item => emit('select', item))
      updateModel()
    }

    const clearAll = () => {
      const cleared = [...selectedItems.value]
      selectedItems.value = []
      cleared.forEach(item => emit('deselect', item))
      updateModel()
    }

    const updateModel = () => {
      emit('update:modelValue', selectedItems.value)
      emit('change', selectedItems.value)
    }

    const handleClickOutside = (event) => {
      if (!event.target.closest('.multi-select-chips')) {
        closeDropdown()
      }
    }

    watch(() => props.modelValue, (newValue) => {
      if (newValue && Array.isArray(newValue)) {
        selectedItems.value = [...newValue]
      }
    }, { immediate: true })

    onMounted(() => {
      document.addEventListener('click', handleClickOutside)
    })

    onUnmounted(() => {
      document.removeEventListener('click', handleClickOutside)
    })

    return {
      isDropdownOpen,
      searchQuery,
      selectedItems,
      filteredItems,
      toggleDropdown,
      closeDropdown,
      isSelected,
      toggleSelection,
      removeSelection,
      selectAll,
      clearAll,
      getItemValue,
      getItemLabel,
      getItemDescription,
      getChipColor
    }
  }
}
</script>

<style scoped>
.dropdown-enter-active, .dropdown-leave-active {
  transition: all 0.2s ease;
}

.dropdown-enter-from, .dropdown-leave-to {
  opacity: 0;
  transform: translateY(-10px);
}
</style>