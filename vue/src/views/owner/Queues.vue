<template>
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-4">
      <h1 class="font-bold text-3xl text-gray-900 px-4 md:px-3">Queue</h1>
      <div class="overflow-x-auto relative py-6">
        <div v-if="loadStatus" class="flex justify-center py-44">
          <svg aria-hidden="true" class="ml-2 w-10 h-10 my-1 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
          </svg>
        </div>
        <div v-else>
          <div class="flex flex-col flex-justify-between px-3 md:flex-row md:space-x-3">
            <div v-if="shops.length" class="w-full h-full border-gray-900 border-t-2 border-b-2 shadow-md px-3 py-3 md:w-3/12">
              <h3 class="font-bold mb-3 text-gray-900">Shop Name</h3>
              <div v-for="shop in shops" :key="shop.id" @click="detail.id != shop.id ? shopQueue(shop.id) : ''" class="cursor-pointer py-3 text-center rounded-md bg-gray-700 text-white">
                {{ shop.application.shop_name }}
              </div>
            </div>
            <div v-else class="w-full h-full border-gray-900 border-t-2 border-b-2 shadow-md px-3 py-3 md:w-2/12">
              <h3 class="font-bold mb-3 text-gray-900">Shop Name</h3>
              <div  class="cursor-allowed py-3 text-center bg-gray-300 text-gray-700">
                No available shop
              </div>
            </div>
            <div class="w-full h-full border-gray-900 border-t-2 border-b-2 shadow-md px-3 py-3 md:w-10/12">
              <button @click="!pendingTable ? toggleTable() : ''"
              :class="[pendingTable ? 'mb-3 text-sm text-white rounded bg-gray-500 px-3 py-2' : 'mb-3 text-sm text-white rounded bg-gray-700 px-3 py-2']">
                Pending
                </button>
              <button @click="pendingTable ? toggleTable() : ''" :class="[!pendingTable ? 'ml-1 mb-3 text-sm text-white rounded bg-gray-500 px-3 py-2' : 'ml-1 mb-3 text-sm text-white rounded bg-gray-700 px-3 py-2']">
                Completed
              </button>
              <!-- PENDING TABLE -->
              <table v-if="pendingTable" class="w-full mx-auto text-sm text-left">
                <thead class="border-b">
                    <tr>
                      <th scope="col" class="py-3 px-6">
                          Service
                      </th>
                      <th scope="col" class="py-3 px-6">
                          #CN
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
                          Status
                      </th>
                      <th scope="col" class="py-3 px-6">
                        Action
                      </th>
                    </tr>
                </thead>
                <tbody v-for="service in detail.services" :key="service.id">
                  <tr v-for="queue in service.queues" :key="queue.id" class="hover:bg-gray-200">
                    <td v-if="queue.status === 'pending'" class="py-4 px-6">
                      {{ queue.service.service_name === 'documents' ? 'Print Document' : 'Print Tarpaulin'}}
                    </td>
                    <td v-if="queue.status === 'pending'" class="py-4 px-6">
                      {{ queue.control_number }}
                    </td>
                    <td v-if="queue.status === 'pending'" class="py-4 px-6">
                      <a :href="queue.document" target="_blank"
                      class="text-blue-700 text-md text-right">Preview</a>
                    </td>
                    <td v-if="queue.status === 'pending'" class="py-4 px-6">
                        {{ capitalizeFirstLetter(queue.size) }}
                    </td>
                    <td v-if="queue.status === 'pending'" class="py-4 px-6">
                        {{ queue.color === 'bnw' ? 'Black and White' : capitalizeFirstLetter(queue.color) }}
                    </td>
                    <td v-if="queue.status === 'pending'" class="py-4 px-6">
                        {{ queue.pages }}
                    </td>
                    <td v-if="queue.status === 'pending'" class="py-4 px-6">
                      <span :class="[queue.status === 'pending' ? 'bg-yellow-300 py-1 px-2 rounded-full text-gray-900' : 'bg-green-300 py-1 px-2 rounded-full text-gray-900']">
                        {{ capitalizeFirstLetter(queue.status) }}
                      </span>
                    </td>
                    <td v-if="queue.status === 'pending'" @click="queue.status === 'pending' ? changeStatus(queue.id) : ''"
                    class="py-4 px-6 text-green-500 hover:text-green-700 hover:text-bold cursor-pointer">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                      </svg>
                    </td>
                  </tr>
                </tbody>
              </table>
              <!-- COMPLETED TABLE -->
              <table v-if="!pendingTable" class="w-full mx-auto text-sm text-left">
                <thead class="border-b">
                    <tr>
                      <th scope="col" class="py-3 px-6">
                          Service
                      </th>
                      <th scope="col" class="py-3 px-6">
                          #CN
                      </th>
                      <th scope="col" class="py-3 px-6">
                          Pick up
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
                          Status
                      </th>
                    </tr>
                </thead>
                <tbody v-for="service in detail.services" :key="service.id">
                  <tr v-for="queue in service.queues" :key="queue.id" class="hover:bg-gray-200">
                    <td v-if="queue.status === 'completed'" class="py-4 px-6">
                      {{ queue.service.service_name === 'documents' ? 'Print Document' : 'Print Tarpaulin'}}
                    </td>
                    <td v-if="queue.status === 'completed'" class="py-4 px-6">
                      {{ queue.control_number }}
                    </td>
                    <td v-if="queue.status === 'completed'" class="py-4 px-6">
                      {{ formatTime(queue.pickup) }}
                    </td>
                    <td v-if="queue.status === 'completed'" class="py-4 px-6">
                      {{ capitalizeFirstLetter(queue.size) }}
                    </td>
                    <td v-if="queue.status === 'completed'" class="py-4 px-6">
                      {{ queue.color === 'bnw' ? 'Black and White' : capitalizeFirstLetter(queue.color) }}
                    </td>
                    <td v-if="queue.status === 'completed'" class="py-4 px-6">
                      {{ queue.pages }}
                    </td>
                    <td v-if="queue.status === 'completed'" class="py-4 px-6">
                      <span :class="[queue.status === 'pending' ? 'bg-yellow-300 py-1 px-2 rounded-full text-gray-900' : 'bg-green-300 py-1 px-2 rounded-full text-gray-900']">
                        {{ capitalizeFirstLetter(queue.status) }}
                      </span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
</template>
<script>
import { computed, ref, watch } from '@vue/runtime-core';
import store from '../../store';
import { alert } from '../../alert'
export default {
  setup(){

    const detail = ref({})
    const pendingTable = ref(true)
    const loadStatus = computed(() => store.state.ownerQueue.loading)
    const shops = computed(() => store.state.ownerQueue.data)

    store.dispatch('getOwnerQueue')
      .then((res) => {
          if(shops.value.length){
            shopQueue(shops.value[shops.value.length -1].id);
          }
        })

    watch(
      () => store.state.ownerShopDetails.data,
      (newVal, oldVal) => {
        detail.value = {
          ...JSON.parse(JSON.stringify(newVal)),
        };
      }
    );

    function shopQueue(id){
      store.dispatch('getShopDetails', id)
    }

    function capitalizeFirstLetter(string) {
      return string.charAt(0).toUpperCase() + string.slice(1);
    }

    function changeStatus(id){
      store.dispatch('updateQueueStatus', id)
        .then((res) => {
          store.dispatch('getOwnerQueue')
            .then((res) => {
              shopQueue(shops.value[shops.value.length -1].id);

              alert('Queue updated!')
          })
        })
    }

    function toggleTable(){
      pendingTable.value = !pendingTable.value
    }

    function formatTime(data){
      const time = data.split(':')
      const hours = Number(time[0]);
      const minutes = Number(time[1]);

      let timeValue;

      if (hours > 0 && hours <= 12) {
        timeValue= "" + hours;
      } else if (hours > 12) {
        timeValue= "" + (hours - 12);
      } else if (hours == 0) {
        timeValue= "12";
      }

      timeValue += (minutes < 10) ? ":0" + minutes : ":" + minutes;  // get minutes
      timeValue += (hours >= 12) ? " P.M." : " A.M.";  // get AM/PM

      return timeValue
    }

    return {
      shops,
      detail,
      loadStatus,
      pendingTable,
      shopQueue,
      capitalizeFirstLetter,
      changeStatus,
      toggleTable,
      formatTime,
    }
  }

}
</script>
<style>

</style>
