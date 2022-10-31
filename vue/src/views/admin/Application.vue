<template>
    <div v-if="loadStatus" class="flex justify-center mt-12">
      Loading..
    </div>
    <div v-else class="px-3 md:px-0">
      <div v-if="applications.length">
        <div class="flex flex-col md:flex-row space-x-3">
          <table class="h-full w-1/2 text-sm border shadow-md  text-gray-500 dark:text-gray-400">
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
                      <th scope="col" class="py-3 px-6">
                          Approve
                      </th>
                  </tr>
              </thead>
              <tbody>
                  <tr @click="detail.id != application.id ? applicationDetails(application.id) : ''" v-for="application in applications"
                  :key="application.id"
                  :class="[application.id === detail.id ? 'bg-blue-100 border-b text-gray-900 cursor-pointer' :
                      'bg-white border-b text-gray-900 cursor-pointer']">
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
                      <td @click="application.staus !== 'approved' ? approveApplication(application.id) : ''" class="py-4 px-6 text-green-500 hover:text-green-700 hover:text-bold">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                      </td>
                  </tr>
              </tbody>
          </table>
          <div  class="h-full w-1/2 border rounded-md shadow-md">
            <div v-if="loadDetailStatus" class="flex justify-center my-12">
              Loading..
            </div>
            <div v-else class="flex justify-around">
              <div class="py-3 px-3 space-y-3 my-6">
                <h1>Shop Information</h1>
                <h1 class="font-semibold border-b-2 shadow-sm py-2 text-gray-900">Shop Name: <span class="font-normal" style="letter-spacing: 1px">{{ detail.shop_name }}</span></h1>
                <h1 class="font-semibold border-b-2 shadow-sm py-2 text-gray-900">Address: <span class="font-normal " style="letter-spacing: 1px">{{ detail.address }}</span></h1>
                <h1 class="font-semibold border-b-2 shadow-sm py-2 text-gray-900">Barangay: <span class="font-normal " style="letter-spacing: 1px">{{ detail.barangay }}</span></h1>
                <h1 class="font-semibold border-b-2 shadow-sm py-2 text-gray-900">City: <span class="font-normal " style="letter-spacing: 1px">{{ detail.city }}</span></h1>
                <h1 class="font-semibold border-b-2 shadow-sm py-2 text-gray-900">Zipcode: <span class="font-normal " style="letter-spacing: 1px">{{ detail.zipcode }}</span></h1>
              </div>
              <div class="py-3 px-3 space-y-3 my-6">
                <h1>Business Owner Information</h1>
                <h1 class="font-semibold border-b-2 shadow-sm py-2 text-gray-900">First Name: <span class="font-normal " style="letter-spacing: 1px">{{ detail.business_owner.first_name }}</span></h1>
                <h1 class="font-semibold border-b-2 shadow-sm py-2 text-gray-900">Middle Name: <span class="font-normal " style="letter-spacing: 1px">{{ detail.business_owner.middle_name }}</span></h1>
                <h1 class="font-semibold border-b-2 shadow-sm py-2 text-gray-900">Last Name: <span class="font-normal " style="letter-spacing: 1px">{{ detail.business_owner.last_name }}</span></h1>
                <h1 class="font-semibold border-b-2 shadow-sm py-2 text-gray-900">Contact Number: <span class="font-normal " style="letter-spacing: 1px">{{ detail.business_owner.contact_number }}</span></h1>
                <h1 class="font-semibold border-b-2 shadow-sm py-2 text-gray-900">Contact Email: <span class="font-normal " style="letter-spacing: 1px">{{ detail.business_owner.contact_email }}</span></h1>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div v-else class="container text-2xl font-bold mx-auto py-44 w-full text-center text-gray-400 shadow-sm bg-gray-100">
        No applications yet.
      </div>

    </div>
</template>

<script>
import { computed, onMounted, ref, watch } from '@vue/runtime-core'
import store from '../../store'
export default {
  setup(){

    const detail = ref({
      shop_name : '',
      address : '',
      barangay : '',
      city : '',
      zipcode : '',
      business_owner : {
        first_name : '',
        middle_name : '',
        last_name : '',
        contact_number : '',
        contact_email : '',
      }
    })

    const loadDetailStatus = computed(() => store.state.applicationDetails.loading)
    const loadStatus = computed(() => store.state.allApplication.loading)
    const applications = computed(() => store.state.allApplication.data)

    watch(
    () => store.state.applicationDetails.data,
    (newVal, oldVal) => {

        detail.value = {
          ...JSON.parse(JSON.stringify(newVal)),
        }

      }
    )

    store.dispatch('getAllApplications')
      .then((res) => {
        // Get the id of latest application and fetch its details
        const value = Object.values(res.data.data)[0]
        store.dispatch('getApplicationDetails', value.id)
    })

    function applicationDetails(id){
      store.dispatch('getApplicationDetails', id)

    }

    function approveApplication(id){
      store.dispatch('approveApplication', id)
        .then(() => {

          store.dispatch('getAllApplications')
            .then((res) => {
              // Get the id of latest application and fetch its details
              const value = id
              store.dispatch('getApplicationDetails', id)
          })

        })

    }

    function formatDateUS(date) {
      const options = { year: 'numeric', month: 'numeric', day: 'numeric' }
      return new Date(date).toLocaleDateString('en-US', options)
    }

    function capitalizeFirstLetter(string) {
      return string.charAt(0).toUpperCase() + string.slice(1);
    }

    return {
      applications,
      loadStatus,
      loadDetailStatus,
      detail,
      formatDateUS,
      capitalizeFirstLetter,
      applicationDetails,
      approveApplication
    }
  }
}
</script>
<style>

</style>
