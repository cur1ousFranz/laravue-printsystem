<template>
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-4">
      <h1 class="font-bold text-3xl text-gray-900 px-4 md:px-3">Your Transactions</h1>
      <div class="overflow-x-auto relative py-6">
        <div v-if="loadStatus" class="flex justify-center py-44">
          <svg aria-hidden="true" class="ml-2 w-10 h-10 my-1 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
          </svg>
        </div>
        <table v-else class="w-full mx-auto text-sm border-gray-900 border-t-2 border-b-2 shadow-md text-left text-gray-500 dark:text-gray-400">
          <thead class="text-xs text-gray-900 uppercase">
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
