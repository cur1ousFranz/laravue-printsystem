<template>
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-4">
      <h1 class="font-bold text-3xl text-gray-900 px-4 md:px-3">Your Transactions</h1>
      <div class="overflow-x-auto relative py-6">
        <div v-if="loadStatus" class="flex justify-center mt-12">
          Loading..
        </div>
        <table v-else class="w-full mx-auto text-sm border shadow-md text-left text-gray-500 dark:text-gray-400">
          <thead class="text-xs text-gray-900 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
              <tr>
                  <th scope="col" class="py-3 px-6">
                      Date
                  </th>
                  <th scope="col" class="py-3 px-6">
                      Shop
                  </th>
                  <th scope="col" class="py-3 px-6">
                      Control Number
                  </th>
                  <th scope="col" class="py-3 px-6">
                      Document
                  </th>
                  <th scope="col" class="py-3 px-6">
                      Size
                  </th>
                  <th scope="col" class="py-3 px-6">
                      Color
                  </th>
                  <th scope="col" class="py-3 px-6">
                      Total Pages
                  </th>
                  <th scope="col" class="py-3 px-6">
                      Total Amount
                  </th>
                  <th scope="col" class="py-3 px-6">
                      Status
                  </th>
              </tr>
          </thead>
          <tbody v-if="transactions.length">
              <tr v-for="transaction in transactions" :key="transaction.id" class="bg-white border-b text-gray-900">
                  <td class="py-4 px-6">
                      {{ formatDateUS(transaction.created_at) }}
                  </td>
                  <td class="py-4 px-6">
                      {{ transaction.service.shop.application.shop_name }}
                  </td>
                  <td class="py-4 px-6">
                      {{ transaction.control_number }}
                  </td>
                  <td class="py-4 px-6">
                      <a class="text-blue-500" :href="transaction.document" target="_blank" >
                        Preview
                      </a>
                  </td>
                  <td class="py-4 px-6">
                      {{ capitalizeFirstLetter(transaction.size) }}
                  </td>
                  <td class="py-4 px-6">
                      {{ transaction.color === 'bnw' ? 'Black and White' : capitalizeFirstLetter(transaction.color) }}
                  </td>
                  <td class="py-4 px-6">
                      {{ transaction.pages }}
                  </td>
                  <td class="py-4 px-6">
                      ₱ {{ transaction.amount }}.00
                  </td>
                  <td class="py-4 px-6">
                    <span :class="[transaction.status === 'pending' ? 'bg-yellow-300 py-1 px-2 rounded-full text-gray-900' : 'bg-green-300 py-1 px-2 rounded-full text-gray-900']">
                      {{ capitalizeFirstLetter(transaction.status) }}
                    </span>
                  </td>
              </tr>
          </tbody>
          <tbody v-else>
            <tr>
              <td class="py-4 px-6">
                Nothing to show
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

</template>
<script>
import { computed } from '@vue/runtime-core'
import store from '../../store'
export default {
  setup() {

  const transactions = computed(() => store.state.customerTransactons.data)
  const loadStatus = computed(() => store.state.customerTransactons.loading)
  store.dispatch('customerAllTransaction')

  function formatDateUS(date) {
    const options = { year: 'numeric', month: 'numeric', day: 'numeric'}
    return new Date(date).toLocaleDateString('en-US', options)
  }

  function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
  }


  return {
    transactions,
    loadStatus,
    formatDateUS,
    capitalizeFirstLetter,
  }
  }
}
</script>
<style>

</style>
