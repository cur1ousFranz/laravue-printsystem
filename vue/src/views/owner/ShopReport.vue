<template>
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-4">
      <h1 class="font-bold text-3xl text-gray-900 px-4 md:px-3">Shop Report</h1>
      <div class="overflow-x-auto relative py-6 my-6  border-gray-900 border-t-2 border-b-2 shadow-md">
        <div v-if="loadStatus" class="flex justify-center py-44">
          <svg aria-hidden="true" class="ml-2 w-10 h-10 my-1 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
          </svg>
        </div>
        <div v-else>
          <table class="h-fit w-full text-sm text-gray-500">
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
                        Admin Commission (20% / page)
                    </th>
                    <th scope="col" class="py-3 px-6">
                        Total
                    </th>
                    <th scope="col" class="py-3 px-6">
                        Date
                    </th>
                    <th scope="col" class="py-3 px-6">
                        Paid
                    </th>
                </tr>
              </thead>
            <tbody class="text-center">
                <tr v-for="queue in shops.data" :key="queue.id">
                    <th class="py-4 px-6">
                      {{ queue.control_number }}
                    </th>
                    <td class="py-4 px-6">
                      {{ capitalizeFirstLetter(queue.size) }}
                    </td>
                    <td class="py-4 px-6">
                      {{ queue.color === 'bnw' ? 'Black and White' : capitalizeFirstLetter(queue.color) }}
                    </td>
                    <td class="py-4 px-6">
                      {{ queue.pages }}
                    </td>
                    <td class="py-4 px-6">
                      ₱ {{ queue.admin_commission }}
                    </td>
                    <td class="py-4 px-6">
                      ₱ {{ queue.amount }}
                    </td>
                    <td class="py-4 px-6">
                    {{ formatDateUS(queue.created_at) }}
                    </td>
                    <td class="py-4 px-6">
                      <span :class="[queue.paid === 'no' ? 'bg-yellow-300 py-1 px-2 rounded-full text-gray-900' :
                      'bg-green-300 py-1 px-2 rounded-full text-gray-900']">
                          {{ queue.paid === 'yes' ? 'Paid' : 'Pending' }}
                        </span>
                    </td>
                </tr>
            </tbody>
          </table>
          <div class="flex justify-between my-6 px-10">
            <h3 class="font-bold my-3 text-gray-900 text-2xl">Current Balance: ₱ {{ countBalance(shops.data) }}</h3>
            <Pagination :pagination="shops" @paginate="view" :offset="4"></Pagination>
          </div>

        </div>
      </div>
    </div>
</template>

<script>
import { computed, ref, watch } from '@vue/runtime-core'
import store from '../../store'
import Pagination from '../../components/Pagination.vue';
import axiosClient from '../../axios'
export default {
  components : { Pagination },
  setup(){

    const loadStatus = computed(() => store.state.ownerReportQueue.loading)
    store.dispatch('getOwnerReportQueue')
    const shops = ref({})

    watch(
      () => store.state.ownerReportQueue.data,
      (newVal, oldVal) => {
        shops.value = {
          ...JSON.parse(JSON.stringify(newVal)),
        }
      }
    )

    function capitalizeFirstLetter(string) {
      return string.charAt(0).toUpperCase() + string.slice(1);
    }

    function view(){
      let current_page = shops.value.current_page
      let pageNum = current_page ? current_page : 1

      axiosClient.get(`/shop/report/queue/?page=${pageNum}`)
        .then((res) => {
          shops.value = res.data.data
        })
    }

    function formatDateUS(date) {
      const options = { year: 'numeric', month: 'numeric', day: 'numeric' }
      return new Date(date).toLocaleDateString('en-US', options)
    }

    function countBalance(queues){
      let total = 0
      if(queues){
        queues.forEach(queue => {
          if(queue.paid === 'no') total += (queue.amount - queue.admin_commission)
        });

      }
      return total.toFixed(2)
    }

    return {
      shops,
      view,
      loadStatus,
      formatDateUS,
      capitalizeFirstLetter,
      countBalance,
    }
  }
}
</script>

<style>

</style>
