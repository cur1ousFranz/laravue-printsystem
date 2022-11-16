<template>
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-4">
      <h1 class="font-bold text-3xl text-gray-900 px-4 md:px-3">Transaction Report</h1>
      <div class="px-4 py-4 sm:px-0">

        <div class="flex space-x-6">
          <div class="w-3/12 h-fit border-gray-900 border-t-2 border-b-2 shadow-md py-3">
            <h3 class="font-bold mb-3 text-gray-900 px-3">Shop Name</h3>
            <div v-for="shop in shops" :key="shop.id" class="text-center py-2 cursor-pointer bg-blue-100">
              <h1>{{ shop.application.shop_name }}</h1>
            </div>
          </div>

          <div class="w-9/12 border-gray-900 border-t-2 border-b-2 shadow-md py-3">
            <h3 class="font-bold mb-3 text-gray-900 px-3">Transactions</h3>
            <div class="px-8">
              <line-chart :data="chartData"></line-chart>
            </div>

            <div class="px-6 py-6">
              qwdqwd
            </div>

          </div>
        </div>

      </div>
    </div>
</template>
<script>
import { computed } from '@vue/runtime-core'
import store from '../../store'
export default {
  setup(){
    store.dispatch('getAllShops')
    const shops = computed(() => store.state.allShops.data)

    const chartData = {
      '2017-05-13': 2,
      '2017-05-14': 5,
      '2017-05-15': 10,
      '2017-05-16': 3,
      '2017-05-17': 3,
      '2017-05-18': 3,
      '2017-05-19': 4,
      '2017-05-20': 5,

    }

    return { shops, chartData }
  }
}


</script>
<style>

</style>
