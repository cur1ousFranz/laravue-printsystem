<template>
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-4">
      <h1 class="font-bold text-3xl text-gray-900 px-4 md:px-3">Shop Details</h1>
        <div v-if="loadStatus" class="flex justify-center py-44">
          <svg aria-hidden="true" class="ml-2 w-10 h-10 my-1 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
          </svg>
        </div>
      <div v-else class="overflow-x-auto relative py-4 ">
        <div class="flex flex-col border-gray-900 border-t-2 py-6 px-8 space-x-6  md:flex-row md:px-4">
          <div class="w-full">
            <div class="flex justify-end py-2">
              <label for="image" class="cursor-pointer px-3 py-2 z-1 my-2 absolute flex hover:bg-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                </svg>
                <p class="text-sm font-bold">Change</p>
                <form action="" enctype="multipart/form-data">
                  <input @change="imgChoose" type="file" class="py-2 border rounded-md" id="image" style="display: none">
                </form>
              </label>
            </div>
            <img class="w-full  hover:shadow-lg" :src="shop.image ? shop.image  : '/img/default-shop-img.jpg'" alt="">
            <div class="flex justify-between my-2">
              <p v-if="shop.status" :class="[shop.status === 'close' ? 'my-3 w-fit text-lg font-bold text-red-500 px-2 py-1 ' :
              'my-3 w-fit text-lg font-bold text-green-500 px-2 py-1 ']">
                {{ capitalizeFirstLetter(shop.status)  }}
              </p>
              <div class="my-3">
                <Button @click="showModal('toggleshop')" class="px-2">
                  <p v-if="shop.status === 'close'">Open Shop</p>
                  <p v-else>Close Shop</p>
                </Button>
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
          <div class="w-full mx-auto">
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
                <span v-if="inArray(shop.services, 'documents')" @click="showModal('service')" class="cursor-pointer">
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
                <form v-if="inArray(shop.services, 'documents')"
                @submit.prevent="savePrintDocsService(getService(shop.services, 'documents')[0])"
                class="space-y-3 py-3 w-full">
                  <h1 class="font-bold mb-3 text-gray-700">Set Price</h1>

                  <!-- A4 SIZE -->
                  <div>
                    <h2 class="font-semibold text-gray-600">A4 SIZE</h2>
                    <div class="flex justify-around space-x-6">
                      <div class="w-full">
                        <label for="long_size" class="form-label inline-block text-sm mb-1 text-gray-700">
                          Black and White
                        </label>
                        <div class="px-5 border border-gray-800 flex align-items-center">
                          <span class="my-2 font-semibold text-gray-600"><h1>₱</h1></span>
                          <input v-model="price.a4_bnw" v-on:keypress="numbersOnly" type="text" id="long_size" class="form-control-sm block w-full px-3 text-sm font-normal text-gray-700 bg-white bg-clip-padding border-0 border-gray-300 transition ease-in-out m-0 focus:ring-0" placeholder="0" maxlength="2"/>
                        </div>
                      </div>
                      <div class="w-full">
                        <label for="long_size" class="form-label inline-block text-sm mb-1 text-gray-700">
                          Colored
                        </label>
                        <div class=" px-5 border border-gray-800 flex align-items-center">
                          <span class="my-2 font-semibold text-gray-600"><h1>₱</h1></span>
                          <input v-model="price.a4_colored" v-on:keypress="numbersOnly" type="text" id="long_size" class="form-control-sm block w-full px-3 text-sm font-normal text-gray-700 bg-white bg-clip-padding border-0 border-gray-300 transition ease-in-out m-0 focus:ring-0" placeholder="0" maxlength="2"/>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- END A4 SIZE -->

                  <!-- LONG SIZE -->
                  <div>
                    <h2 class="font-semibold text-gray-600">LONG SIZE</h2>
                    <div class="flex justify-around space-x-6">
                      <div class="w-full">
                        <label for="long_size" class="form-label inline-block text-sm mb-1 text-gray-700">
                          Black and White
                        </label>
                        <div class=" px-5 border border-gray-800 flex align-items-center">
                          <span class="my-2 font-semibold text-gray-600"><h1>₱</h1></span>
                          <input v-model="price.long_bnw" v-on:keypress="numbersOnly" type="text" id="long_size" class="form-control-sm block w-full px-3 text-sm font-normal text-gray-700 bg-white bg-clip-padding border-0 border-gray-300 transition ease-in-out m-0 focus:ring-0" placeholder="0" maxlength="2"/>
                        </div>
                      </div>
                      <div class="w-full">
                        <label for="long_size" class="form-label inline-block text-sm mb-1 text-gray-700">
                          Colored
                        </label>
                        <div class="px-5 border border-gray-800 flex align-items-center">
                          <span class="my-2 font-semibold text-gray-600"><h1>₱</h1></span>
                          <input v-model="price.long_colored" v-on:keypress="numbersOnly" type="text" id="long_size" class="form-control-sm block w-full px-3 text-sm font-normal text-gray-700 bg-white bg-clip-padding border-0 border-gray-300 transition ease-in-out m-0 focus:ring-0" placeholder="0" maxlength="2"/>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- END LONG SIZE -->

                  <!--  SHORT SIZE -->
                  <div>
                    <h2 class="font-semibold text-gray-600">SHORT SIZE</h2>
                    <div class="flex justify-around space-x-6">
                      <div class="w-full">
                        <label for="long_size" class="form-label inline-block text-sm mb-1 text-gray-700">
                            Black and White
                        </label>
                        <div class="px-5 border border-gray-800 flex align-items-center">
                          <span class="my-2 font-semibold text-gray-600"><h1>₱</h1></span>
                          <input v-model="price.short_bnw" v-on:keypress="numbersOnly" type="text" id="long_size" class="form-control-sm block w-full px-3 text-sm font-normal text-gray-700 bg-white bg-clip-padding border-0 border-gray-300 transition ease-in-out m-0 focus:ring-0" placeholder="0" maxlength="2"/>
                        </div>
                      </div>
                      <div class="w-full">
                        <label for="long_size" class="form-label inline-block text-sm mb-1 text-gray-700">
                          Colored
                        </label>
                        <div class="px-5 border border-gray-800 flex align-items-center">
                          <span class="my-2 font-semibold text-gray-600"><h1>₱</h1></span>
                          <input v-model="price.short_colored" v-on:keypress="numbersOnly" type="text" id="long_size" class="form-control-sm block w-full px-3 text-sm font-normal text-gray-700 bg-white bg-clip-padding border-0 border-gray-300 transition ease-in-out m-0 focus:ring-0" placeholder="0" maxlength="2"/>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- END SHORT SIZE -->
                  <div class="flex justify-end">
                    <Button>
                      Save Service
                    </Button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="w-10/12 mx-auto px-3 mt-16 py-4 space-y-4 border-gray-900 border-t-2 border-b-2 shadow-md relative">
        <h1 class="text-2xl font-bold text-gray-800 my-3">Shop Reviews</h1>
        <div style="min-height: 200px">
          <div v-if="reviewLoadStatus" class="flex justify-center mt-12">
            <svg aria-hidden="true" class="ml-2 w-16 h-16 my-1 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
              <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
            </svg>
          </div>
          <div v-else>
            <div v-if="reviews.length">
              <div v-for="review in reviews" :key="review.id" class="flex space-x-3 py-2 my-3 border-b">
                <div>
                  <img class="w-10" src="/img/default-profile.png" alt="">
                </div>
                <div class="w-full hover:bg-gray-200 hover:rounded-lg">
                  <h2 class="px-3 font-bold text-gray-700">{{ review.customer.first_name }} {{ review.customer.middle_name ?? ''  }} {{ review.customer.last_name }} | <span class="text-sm font-normal">
                    {{ formatDateUS(review.created_at) }}
                  </span>
                  </h2>
                  <h2 class="px-3 py-1 rounded-md w-full">{{ review.body }}</h2>
                </div>
              </div>
            </div>
            <div v-else class="py-12">
              <h1 class="text-gray-500 text-2xl font-bold text-center">No reviews yet.</h1>
            </div>
          </div>
        </div>
      </div>

      <Modal v-show="isModalVisible" @close="closeModal" @some-event="confirm" >
        <template v-slot:header>
          Are you sure you want to proceed?
        </template>

        <!-- <template v-slot:body>
          Are you sure you want to proceed?
        </template> -->

        <template v-slot:footer>
          This is a new modal footer.
        </template>
      </Modal>

    </div>
</template>
<script setup>
import { computed, watch } from "@vue/runtime-core";
import { ref } from '@vue/reactivity'
import { useRoute } from "vue-router";
import { alert } from '../../alert.js'
import store from "../../store";
import  Button  from '../../components/Button.vue'
import Modal from '../../components/Modal.vue'

  const isModalVisible = ref(false)
  const route = useRoute();
  const printDocsService = ref(false);
  const loadStatus = computed(() => store.state.ownerShopDetails.loading)
  const reviews = computed(() => store.state.shopReviews.data)
  const reviewLoadStatus = computed(() => store.state.shopReviews.loading)
  let button
  const shop = ref({
    status : null,
    application : {},
    services : []
  })
  const price = ref({
    a4_bnw : null,
    a4_colored : null,
    long_bnw : null,
    long_colored : null,
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

    store.dispatch('getShopReviews', route.params.id)
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

      if(shop.value.services.length){
        const service = getService(shop.value.services, 'documents')
        if(service[0].service_price.price != null){
          shop.value.status = 'open'

        }else{
          alert('Please add service & prices', 'error')
          return
        }
      }else{
        alert('Please add service & prices', 'error')
        return
      }
    }else{
      shop.value.status = 'close'
    }

    store.dispatch('setToggleShop', shop.value)
      .then(() => {
        alert(`Shop ${shop.value.status} successfully!`)
      })
  }

  function imgChoose(e){

    const formData = new FormData()
    formData.append('image', e.target.files[0])
    formData.append('shop_id', shop.value.id)

    store.dispatch('setShopImage', formData)
      .then(() => {
        store.dispatch("getShopDetails", route.params.id)
        alert('Update banner image')
      })
  }

  function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
  }

  function showModal(from){
    button = from
    isModalVisible.value = true
  }

  function confirm(){
    if(button === 'service'){
      deletePrintService()
    }else{
      toggleShop()
    }
  }

  function closeModal(){
    isModalVisible.value = false
  }

  function formatDateUS(date) {
    const options = { year: 'numeric', month: 'numeric', day: 'numeric'}
    return new Date(date).toLocaleDateString('en-US', options)
  }

</script>
