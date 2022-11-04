<template>
  <div class="mx-auto max-w-7xl sm:px-6 lg:px-4">

    <div class="overflow-x-auto relative">
        <div v-if="loadStatus" class="flex justify-center mt-12">
          Loading..
        </div>
        <table v-else class="w-10/12 mx-auto text-sm border shadow-md text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-900 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="py-3 px-6">
                        Shop name
                    </th>
                    <th scope="col" class="py-3 px-6">
                        Applied Date
                    </th>
                    <th scope="col" class="py-3 px-6">
                        Status
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="application in applications" :key="application.id" class="bg-white border-b text-gray-900">
                    <th class="py-4 px-6">
                        {{ application.shop_name }}
                    </th>
                    <td class="py-4 px-6">
                        {{ formatDateUS(application.created_at) }}
                    </td>
                    <td class="py-4 px-6">
                      <span :class="[application.status === 'pending' ? 'bg-yellow-300 py-1 px-2 rounded-full text-gray-900' : 'bg-green-300 py-1 px-2 rounded-full text-gray-900']">
                        {{ capitalizeFirstLetter(application.status) }}
                      </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

  </div>
</template>
<script>

import { computed, onMounted } from '@vue/runtime-core'
import store from '../../store'
export default {
  setup() {

    const loadStatus = computed(() => store.state.ownerApplication.loading)
    const applications = computed(() => store.state.ownerApplication.data)
    store.dispatch('getShopOwnerApplications')

  function formatDateUS(date) {
      const options = { year: 'numeric', month: 'numeric', day: 'numeric' }
      return new Date(date).toLocaleDateString('en-US', options)
  }

  function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
  }
    return {  applications, formatDateUS, loadStatus, capitalizeFirstLetter }
  }
}
</script>
<style>

</style>
