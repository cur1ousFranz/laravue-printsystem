<template>
  <div class="container">
    <h1 class="font-bold text-3xl text-gray-900 px-4 md:px-3">Notification</h1>
    <div class="text-center py-4 px-12 my-6 w-1/2 border border-gray-700 shadow-sm mx-auto space-y-6">
      <h2 class="text-2xl font-mono">Printing Documents</h2>
      <div>
        <h2 v-if="details.service">{{ details.service.shop.application.shop_name }}</h2>
        <h2 v-if="details.service">
          {{ details.service.shop.application.address }}, {{ details.service.shop.application.barangay }}
        </h2>
        <h2 v-if="details.service">
          {{ details.service.shop.application.city }}, {{ details.service.shop.application.zipcode }}
        </h2>
      </div>
      <div v-if="details.customer" class="text-left space-y-3 py-3">
        <h1 class=" font-medium text-gray-800">Date: {{ formatDateUS(details.created_at) }}</h1>
        <h1 class=" font-medium text-gray-800">Control Number: {{ details.control_number }}</h1>
        <h2 class=" font-medium text-gray-800">Customer Name: {{ details.customer.last_name }}, {{ details.customer.first_name }} {{ details.customer.middle_name }}</h2>
        <h2 class=" font-medium text-gray-800">Service: Printing {{ details.service.service_name }}</h2>
        <h2 class=" font-medium text-gray-800">Size: {{ capitalizeFirstLetter(details.size) }}</h2>
        <h2 class=" font-medium text-gray-800">Color: {{ details.color === 'bnw' ? 'Black and White' : capitalizeFirstLetter(details.color) }}</h2>
        <h2 class=" font-medium text-gray-800">Total Pages: {{ details.pages }}</h2>
        <h2 class=" font-medium text-gray-800">Status: {{ capitalizeFirstLetter(details.status) }}</h2>
        <div class="flex justify-end">
          <h2 class="text-lg  border-b-2 border-gray-700 font-medium text-gray-800">Total Amount: ₱ {{ details.amount }}.00</h2>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { ref } from '@vue/reactivity';
import { useRoute } from "vue-router";
import store from '../../store';
export default {
  setup(){
    const route = useRoute()
    const details = ref({})
    if(route.params.id){
      store.dispatch('getCustomerNotificationDetails', route.params.id)
        .then((res) => {
          details.value = res.data.data
        })
    }

    function capitalizeFirstLetter(string) {
      return string.charAt(0).toUpperCase() + string.slice(1);
    }

    function formatDateUS(date) {
      const options = { year: 'numeric', month: 'numeric', day: 'numeric' }
      return new Date(date).toLocaleDateString('en-US', options)
    }

    return {
      details,
      capitalizeFirstLetter,
      formatDateUS
    }
  }
}
</script>
<style>

</style>
