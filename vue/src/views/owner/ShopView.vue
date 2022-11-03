<template>
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-4">
      <h1 class="font-bold text-3xl text-gray-900 px-4 md:px-3">Shop Details</h1>
      <div class="overflow-x-auto relative py-4">
        <div class="flex flex-col border rounded-md shadow-md py-6 px-8 space-x-6 md:flex-row">
          <div class="w-full">
            <img class="w-full rounded-md hover:shadow-lg" src="https://flowbite.com/docs/images/blog/image-1.jpg" alt="">
            <div class="flex justify-between my-2">
              <p v-if="shop.status" :class="[shop.status === 'close' ? 'my-3 w-fit text-lg font-bold text-red-500 px-2 py-1 rounded-md' :
              'my-3 w-fit text-lg font-bold text-green-500 px-2 py-1 rounded-md']">
                {{ capitalizeFirstLetter(shop.status)  }}
              </p>
              <div class="my-3">
                <button @click="toggleShop()" class="px-3 py-3 rounded-full text-sm font-medium bg-gray-800 text-white hover:bg-gray-900">
                 <p v-if="shop.status === 'close'">Open Shop</p>
                 <p v-else>Close Shop</p>
                </button>
              </div>
            </div>
            <p class="my-3 text-lg font-semibold text-gray-900" style="letter-spacing: 1px">
              {{ shop.application.shop_name }}
            </p>
            <p class="mb-3 text-sm font-semibold text-gray-900" style="letter-spacing: 1px">
              {{ shop.application.address }} , {{ shop.application.barangay }} , {{ shop.application.city }}, {{ shop.application.zipcode }}
            </p>
          </div>
          <div class="left-1/2 -ml-0.5 w-0.5 bg-gray-400"></div>
          <div class="w-full">
            <h1 class="font-bold mb-3 text-2xl">Services</h1>
            <div v-if="loadStatus" class="flex justify-center py-44">
              Loading..
            </div>
            <div v-else class="py-3">
              <div class="flex align-content-center">
                <span v-if="!inArray(shop.services, 'documents')" @click="addPrintService" class="cursor-pointer">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 border-2 border-gray-800 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                  </svg>
                </span>
                <span v-if="inArray(shop.services, 'documents')" @click="deletePrintService" class="cursor-pointer">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 border-2 text-red-500 border-red-500 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                </span>
                <h1 class="font-bold mb-3 text-gray-800">Printing Documents</h1>
              </div>
              <div v-if="!shop.services.length" class="py-32 rounded-md bg-gray-200 text-center text-gray-500">
                <h1 class="text-2xl font-bold">No services yet.</h1>
              </div>
              <div v-else class="flex">
                <form v-if="inArray(shop.services, 'documents')" @submit.prevent="savePrintDocsService(getService(shop.services, 'documents')[0])" class="space-y-3 py-3">
                  <h1 class="font-bold mb-3 text-gray-700">Set Price</h1>
                    <!-- A4 SIZE -->
                    <div class="flex justify-around space-x-6">
                      <div class="flex flex-col justify-center space-x-0 md:flex-row md:space-x-3">
                        <div>
                          <label for="long_size" class="form-label inline-block text-sm mb-1 text-gray-700">
                            A4 Size
                          </label>
                          <input v-model="price.a4" v-on:keypress="numbersOnly" type="text" id="long_size" class="form-control-sm block w-full px-3 text-sm font-normal text-gray-700 bg-white bg-clip-padding  border border-solid border-gray-300 rounded transition ease-in-out m-0  focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" placeholder="₱" maxlength="2"/>
                        </div>
                        <div class="hidden mt-8 text-gray-900 md:block">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"  stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                          </svg>
                        </div>
                        <div class="flex space-x-2">
                          <div>
                            <label for="long_size" class="form-label inline-block text-sm mb-1 text-gray-700">
                              B&W
                            </label>
                            <input v-model="price.a4_bnw" v-on:keypress="numbersOnly" type="text" id="long_size" class="form-control-sm block w-full px-3 text-sm font-normal text-gray-700 bg-white bg-clip-padding  border border-solid border-gray-300 rounded transition ease-in-out m-0  focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" placeholder="₱"  maxlength="2"/>
                          </div>
                          <div>
                            <label for="long_size" class="form-label inline-block text-sm mb-1 text-gray-700">
                              Colored
                            </label>
                            <input v-model="price.a4_colored" v-on:keypress="numbersOnly" type="text" id="long_size" class="form-control-sm block w-full px-3 text-sm font-normal text-gray-700 bg-white bg-clip-padding  border border-solid border-gray-300 rounded transition ease-in-out m-0  focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" placeholder="₱" maxlength="2"/>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- END A4 SIZE -->

                    <!-- LONG SIZE -->
                    <div class="flex justify-around space-x-6">
                      <div class="flex flex-col justify-center space-x-0 md:flex-row md:space-x-3">
                        <div>
                          <label for="long_size" class="form-label inline-block text-sm mb-1 text-gray-700">
                            Long Size
                          </label>
                          <input v-model="price.long" v-on:keypress="numbersOnly" type="text" id="long_size" class="form-control-sm block w-full px-3 text-sm font-normal text-gray-700 bg-white bg-clip-padding  border border-solid border-gray-300 rounded transition ease-in-out m-0  focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" placeholder="₱" maxlength="2"/>
                        </div>
                        <div class="hidden mt-8 text-gray-900 md:block">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"  stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                          </svg>
                        </div>
                        <div class="flex space-x-2">
                          <div>
                            <label for="long_size" class="form-label inline-block text-sm mb-1 text-gray-700">
                              B&W
                            </label>
                            <input v-model="price.long_bnw" v-on:keypress="numbersOnly" type="text" id="long_size" class="form-control-sm block w-full px-3 text-sm font-normal text-gray-700 bg-white bg-clip-padding  border border-solid border-gray-300 rounded transition ease-in-out m-0  focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" placeholder="₱" maxlength="2"/>
                          </div>
                          <div>
                            <label for="long_size" class="form-label inline-block text-sm mb-1 text-gray-700">
                              Colored
                            </label>
                            <input v-model="price.long_colored" v-on:keypress="numbersOnly" type="text" id="long_size" class="form-control-sm block w-full px-3 text-sm font-normal text-gray-700 bg-white bg-clip-padding  border border-solid border-gray-300 rounded transition ease-in-out m-0  focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" placeholder="₱" maxlength="2"/>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- END LONG SIZE -->

                    <!--  SHORT SIZE -->
                    <div class="flex justify-around space-x-6">
                      <div class="flex flex-col justify-center space-x-0 md:flex-row md:space-x-3">
                        <div>
                          <label for="long_size" class="form-label inline-block text-sm mb-1 text-gray-700">
                            Short Size
                          </label>
                          <input v-model="price.short" v-on:keypress="numbersOnly" type="text" id="long_size" class="form-control-sm block w-full px-3 text-sm font-normal text-gray-700 bg-white bg-clip-padding  border border-solid border-gray-300 rounded transition ease-in-out m-0  focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" placeholder="₱" maxlength="2"/>
                        </div>
                        <div class="hidden mt-8 text-gray-900 md:block">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"  stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                          </svg>
                        </div>
                        <div class="flex space-x-2">
                          <div>
                            <label for="long_size" class="form-label inline-block text-sm mb-1 text-gray-700">
                              B&W
                            </label>
                            <input v-model="price.short_bnw" v-on:keypress="numbersOnly" type="text" id="long_size" class="form-control-sm block w-full px-3 text-sm font-normal text-gray-700 bg-white bg-clip-padding  border border-solid border-gray-300 rounded transition ease-in-out m-0  focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" placeholder="₱" maxlength="2"/>
                          </div>
                          <div>
                            <label for="long_size" class="form-label inline-block text-sm mb-1 text-gray-700">
                              Colored
                            </label>
                            <input v-model="price.short_colored" v-on:keypress="numbersOnly" type="text" id="long_size" class="form-control-sm block w-full px-3 text-sm font-normal text-gray-700 bg-white bg-clip-padding  border border-solid border-gray-300 rounded transition ease-in-out m-0  focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" placeholder="₱" maxlength="2"/>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- END SHORT SIZE -->

                    <div class="flex justify-end">
                      <button type="submit" class="py-2 mt-3 px-3 rounded-md shadow-sm text-sm text-white bg-gray-700 hover:bg-gray-800 ">Save Service</button>
                    </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</template>
<script setup>
import { computed, watch } from "@vue/runtime-core";
import { ref } from '@vue/reactivity'
import { useRoute } from "vue-router";
import { alert } from '../../alert.js'
import store from "../../store";

  const route = useRoute();
  const printDocsService = ref(false);
  const loadStatus = computed(() => store.state.ownerShopDetails.loading)

  const shop = ref({
    status : null,
    application : {},
    services : []
  })

  const price = ref({
    a4 : null,
    a4_bnw : null,
    a4_colored : null,
    long : null,
    long_bnw : null,
    long_colored : null,
    short : null,
    short_bnw : null,
    short_colored : null,
  })

  watch(
    () => store.state.ownerShopDetails.data,
    (newVal, oldVal) => {
      shop.value = {
        ...JSON.parse(JSON.stringify(newVal)),
      };
    }
  );

  if(route.params.id){
    store.dispatch("getShopDetails", route.params.id)
      .then((res) => {
        if(shop.value.services.length){
          if(inArray(shop.value.services, 'documents')){
            const service = getService(shop.value.services, 'documents')
            if(service[0].service_price.price){
              service[0].service_price.price = JSON.parse(service[0].service_price.price)
              price.value = service[0].service_price.price
            }
          }
        }
        return res
      })
  }

  // Get Service according to passed service_name
  function getService(array, string){
    return array.filter((service) => service.service_name === string)
  }

  // Check if the service name is in array of objects
  function inArray(array, name){
    const checkServiceName = obj => obj.service_name === name;
    return array.some(checkServiceName)
  }

  function addPrintService(){
    store.dispatch('setShopPrintDocsService', shop.value)
      .then(() => {
        alert('Service added!')
      })
  }

  function deletePrintService(){
    store.dispatch('removeShopPrintDocsService', shop.value)
      .then(() => {
        alert('Service removed!')
      })

  }

  function savePrintDocsService(service){
    service.service_price.price = price.value
    store.dispatch('setPrintDocsServicePrice', shop.value)
      .then(() => {
        alert('Update service successfully!')
      })

  }

  // function for input fields to allow only numbers
  function numbersOnly(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
      evt.preventDefault();;
    } else {
      return true;
    }
  }

  function toggleShop(){
    if(shop.value.status === 'close'){
      shop.value.status = 'open'
    }else{
      shop.value.status = 'close'
    }

    store.dispatch('setToggleShop', shop.value)
      .then(() => {
        alert(`Shop ${shop.value.status} successfully!`)
      })
  }

  function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
  }

</script>
