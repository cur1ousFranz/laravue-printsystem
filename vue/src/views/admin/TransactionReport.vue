<template>
<<<<<<< HEAD
    <div v-if="loadStatus" class="flex justify-center py-44">
      <svg aria-hidden="true" class="ml-2 w-10 h-10 my-1 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
      </svg>
    </div>
    <div v-else class="mx-auto max-w-7xl sm:px-6 lg:px-4">
      <h1 class="font-bold text-3xl text-gray-900 px-4 md:px-3">Transaction Report</h1>
      <div class="px-4 py-4 sm:px-0">

        <div v-if="shops.length" class="flex space-x-6">
          <div class="w-3/12 h-fit border-gray-900 border-t-2 border-b-2 shadow-md py-3">
            <h3 class="font-bold mb-3 text-gray-900 px-3">Shop Name</h3>
            <div  @click="detail.id != shop.id ? shopTransactions(shop.id) : ''" v-for="shop in shops" :key="shop.id" :class="[shop.id === currentShop ? 'bg-blue-100 text-center py-3 border-b text-gray-900 cursor-pointer' : 'bg-white border-b text-center py-3 text-gray-900 cursor-pointer']">
              <h1>{{ shop.application.shop_name }}</h1>
            </div>
          </div>
          <div class="w-9/12 border-gray-900 border-t-2 border-b-2 shadow-md py-3">
            <div v-if="loadDetailStatus" class="flex justify-center py-44">
              <svg aria-hidden="true" class="ml-2 w-10 h-10 my-1 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
              </svg>
            </div>
            <div v-else class="px-8">
              <h3 class="font-bold mb-3 text-gray-900">Transactions</h3>
              <div class="px-2 py-6 shadow-md border mb-6">
                <table class="h-full w-full text-sm  text-gray-500">
                  <thead class="text-xs text-gray-900 uppercase">
                      <tr>
                          <th scope="col" class="py-3 px-6">
                              #CN
                          </th>
                          <th scope="col" class="py-3 px-6">
                              Size
                          </th>
                          <th scope="col" class="py-3 px-6">
                              Color
                          </th>
                          <th scope="col" class="py-3 px-6">
                              Pages
                          </th>
                          <th scope="col" class="py-3 px-6">
                              Admin Commission
                          </th>
                          <th scope="col" class="py-3 px-6">
                              Total
                          </th>
                      </tr>
                    </thead>
                  <tbody v-if="detail.data" class="text-center">
                      <tr v-for="transaction in detail.data" :key="transaction.id">
                          <th class="py-4 px-6">
                            {{ transaction.control_number }}
                          </th>
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
                            ₱ {{ transaction.admin_commission }}
                          </td>
                          <td class="py-4 px-6">
                            ₱ {{ transaction.amount }}
                          </td>
                      </tr>
                  </tbody>
                </table>

                <div class="flex justify-end my-3 px-3">
                  <Pagination :pagination="detail" @paginate="view" :offset="4"></Pagination>
                </div>
              </div>
              <div v-if="shopDetails.application" class="px-6 py-6 shadow-md border space-y-6">
                <h3 class="font-bold mb-3 text-gray-900">Payment Details</h3>
                <h1 class="font-semibold">Shop Owner:
                  <span class="font-normal"> {{ shopDetails.application.business_owner.last_name }}, {{ shopDetails.application.business_owner.first_name }} {{ shopDetails.application.business_owner.middle_name }}</span>
                </h1>
                <h1 class="font-semibold">G-cash Number:
                  <span class="font-normal">{{ shopDetails.application.business_owner.contact_number }}</span>
                </h1>
                <div class="flex justify-between">
                  <h1 class="font-semibold">Available Balance: ₱
                    <span class="font-normal">{{ countBalance(shopDetails.services[0].queues) }}</span>
                  </h1>
                  <!-- <Button class="p-2 h-fit">Paid</Button> -->
                  <button @click="paid()" class="border px-6 py-3 shadow-sm bg-gray-800 border-gray-900 text-white hover:bg-gray-900" :disabled="countBalance(shopDetails.services[0].queues) == 0 ? true : false">
                    Paid
                  </button>
                </div>
              </div>
            </div>
=======
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

>>>>>>> 7949fc94600223f672685d05b9cd420d6f7c1e7e
          </div>
        </div>

      </div>
    </div>
</template>
<script>
<<<<<<< HEAD
import { computed, ref, watch } from '@vue/runtime-core'
import store from '../../store'
import axiosClient from '../../axios'
import Pagination from '../../components/Pagination.vue';
import  Button  from '../../components/Button.vue'
import { alert } from '../../alert'
export default {
  components : { Pagination, Button },
  setup(){

    const detail = ref({})
    const currentShop = ref()
    const shopDetails = ref({})

    store.dispatch('getAllShops')
      .then((res) => {
        // Get the id of latest application and fetch its details
        const value = Object.values(res.data.data)[0]
        currentShop.value = value.id
        if(value){
          store.dispatch('getShopDetails', value.id)
          store.dispatch('getShopTransactionDetails', value.id)
        }
    })

    const loadStatus = computed(() => store.state.allShops.loading)
    const loadDetailStatus = computed(() => store.state.shopTransactionDetails.loading)
    const shops = computed(() => store.state.allShops.data)
    // const shopDetails = computed(() => store.state.ownerShopDetails.data)

    watch(
    () => store.state.ownerShopDetails.data,
    (newVal, oldVal) => {

        shopDetails.value = {
          ...JSON.parse(JSON.stringify(newVal)),
        }

      }
    )

    watch(
    () => store.state.shopTransactionDetails.data,
    (newVal, oldVal) => {

        detail.value = {
          ...JSON.parse(JSON.stringify(newVal)),
        }

      }
    )

    function countBalance(queues){

      let total = 0
      queues.forEach(queue => {
        if(queue.paid === 'no'){
          total += (queue.amount - queue.admin_commission)
        }
      });

      return total.toFixed(2)
    }

    function shopTransactions(id){
      currentShop.value = id
      store.dispatch('getShopDetails', id)
      store.dispatch('getShopTransactionDetails', id)
    }

    function view(){
      let current_page = detail.value.current_page
      let pageNum = current_page ? current_page : 1

      axiosClient.get(`/transaction/shop/${currentShop.value}?page=${pageNum}`)
        .then((res) => {
          detail.value = res.data.data
        })
    }

    function paid(){
      store.dispatch('setShopTransactionDetails', currentShop.value)
        .then((res) => {
          store.dispatch('getAllShops')
            .then((res) => {
              // Get the id of latest application and fetch its details
              const value = Object.values(res.data.data)[0]
              currentShop.value = value.id
              if(value){
                store.dispatch('getShopDetails', value.id)
                store.dispatch('getShopTransactionDetails', value.id)
              }
          })

          alert('Paid success!')
        })
    }

    function capitalizeFirstLetter(string) {
      return string.charAt(0).toUpperCase() + string.slice(1);
    }

    return {
      shops,
      detail,
      loadStatus,
      paid,
      currentShop,
      shopDetails,
      loadDetailStatus,
      shopTransactions,
      view,
      countBalance,
      capitalizeFirstLetter,
    }
=======
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
>>>>>>> 7949fc94600223f672685d05b9cd420d6f7c1e7e
  }
}


</script>
<style>

</style>
