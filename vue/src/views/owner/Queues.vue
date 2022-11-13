<template>
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-4">
      <h1 class="font-bold text-3xl text-gray-900 px-4 md:px-3">Queue</h1>
      <div class="overflow-x-auto relative py-6">
        <div v-if="loadStatus" class="flex justify-center mt-12">
          Loading..
        </div>
        <div v-else>
          <div class="flex flex-col flex-justify-between px-3 md:flex-row md:space-x-3">
            <div v-if="shops.length" class="w-full h-full border shadow-md px-3 py-3 md:w-3/12">
              <h3 class="font-bold mb-3 text-gray-900">Shop Name</h3>
              <div v-for="shop in shops" :key="shop.id" @click="detail.id != shop.id ? shopQueue(shop.id) : ''" class="cursor-pointer py-3 text-center rounded-md bg-gray-700 text-white">
                {{ shop.application.shop_name }}
              </div>
            </div>
            <div v-else class="w-full h-full border shadow-md px-3 py-3 md:w-2/12">
              <h3 class="font-bold mb-3 text-gray-900">Shop Name</h3>
              <div  class="cursor-allowed py-3 text-center bg-gray-300 text-gray-700">
                No available shop
              </div>
            </div>
            <div class="w-full h-full border shadow-md px-3 py-3 md:w-10/12">
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
