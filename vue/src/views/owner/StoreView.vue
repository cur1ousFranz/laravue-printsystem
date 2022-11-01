<template>
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-4">
      <h1 class="font-bold text-3xl text-gray-900 px-4 md:px-3">Shop Details</h1>
      <div class="overflow-x-auto relative py-4">
        <div class="flex flex-col border rounded-md shadow-md py-6 px-8 space-x-6 md:flex-row">
          <div class="w-full">
            <img class="w-full rounded-md hover:shadow-lg" src="https://flowbite.com/docs/images/blog/image-1.jpg" alt="">
            <div class="flex justify-between my-2">
              <p :class="[shop.status === 'close' ? 'my-3 w-fit text-lg font-bold text-red-500 px-2 py-1 rounded-md' :
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
            <h1 class="font-bold mb-3">Services</h1>
            <div class="form-check">
              <input v-model="printDocsService" class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="checkbox" value="" id="flexCheckDefault">
              <label class="form-check-label inline-block text-gray-800" for="flexCheckDefault">
                Printing Document
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="checkbox" value="" id="flexCheckChecked" disabled>
              <label class="form-check-label line-through inline-block text-gray-600" for="flexCheckChecked">
                Printing Tarpaulin
              </label>
            </div>
            <div v-if="!printDocsService" class="bg-gray-100 py-32 font-bold rounded-md my-2 text-center text-gray-500">
              No service selected
            </div>
            <div v-else class="py-3">
              <h1 class="font-bold mb-3">Set Price</h1>
              <div class="flex">
                <form @submit.prevent="saveService()" class="space-y-3">
                  <!-- A4 SIZE -->
                  <div class="flex justify-around space-x-6">
                    <div class="flex flex-col justify-center space-x-0 md:flex-row md:space-x-3">
                      <div>
                        <label for="long_size" class="form-label inline-block text-sm mb-1 text-gray-700">
                          A4 Size
                        </label>
                        <input v-model="shop.price.a4_size.price" v-on:keypress="numbersOnly" type="text" id="long_size" class="form-control-sm block w-full px-3 text-sm font-normal text-gray-700 bg-white bg-clip-padding  border border-solid border-gray-300 rounded transition ease-in-out m-0  focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" placeholder="₱" maxlength="2"/>
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
                          <input v-model="shop.price.a4_size.black_and_white" v-on:keypress="numbersOnly" type="text" id="long_size" class="form-control-sm block w-full px-3 text-sm font-normal text-gray-700 bg-white bg-clip-padding  border border-solid border-gray-300 rounded transition ease-in-out m-0  focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" placeholder="₱"  maxlength="2"/>
                        </div>
                        <div>
                          <label for="long_size" class="form-label inline-block text-sm mb-1 text-gray-700">
                            Colored
                          </label>
                          <input v-model="shop.price.a4_size.colored" v-on:keypress="numbersOnly" type="text" id="long_size" class="form-control-sm block w-full px-3 text-sm font-normal text-gray-700 bg-white bg-clip-padding  border border-solid border-gray-300 rounded transition ease-in-out m-0  focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" placeholder="₱" maxlength="2"/>
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
                        <input v-model="shop.price.long_size.price" v-on:keypress="numbersOnly" type="text" id="long_size" class="form-control-sm block w-full px-3 text-sm font-normal text-gray-700 bg-white bg-clip-padding  border border-solid border-gray-300 rounded transition ease-in-out m-0  focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" placeholder="₱" maxlength="2"/>
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
                          <input v-model="shop.price.long_size.black_and_white" v-on:keypress="numbersOnly" type="text" id="long_size" class="form-control-sm block w-full px-3 text-sm font-normal text-gray-700 bg-white bg-clip-padding  border border-solid border-gray-300 rounded transition ease-in-out m-0  focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" placeholder="₱" maxlength="2"/>
                        </div>
                        <div>
                          <label for="long_size" class="form-label inline-block text-sm mb-1 text-gray-700">
                            Colored
                          </label>
                          <input v-model="shop.price.long_size.colored" v-on:keypress="numbersOnly" type="text" id="long_size" class="form-control-sm block w-full px-3 text-sm font-normal text-gray-700 bg-white bg-clip-padding  border border-solid border-gray-300 rounded transition ease-in-out m-0  focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" placeholder="₱" maxlength="2"/>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- END LONG SIZE -->

                  <!-- SHORT SIZE -->
                  <div class="flex justify-around space-x-6">
                    <div class="flex flex-col justify-center space-x-0 md:flex-row md:space-x-3">
                      <div>
                        <label for="long_size" class="form-label inline-block text-sm mb-1 text-gray-700">
                          Short Size
                        </label>
                        <input v-model="shop.price.short_size.price" v-on:keypress="numbersOnly" type="text" id="long_size" class="form-control-sm block w-full px-3 text-sm font-normal text-gray-700 bg-white bg-clip-padding  border border-solid border-gray-300 rounded transition ease-in-out m-0  focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" placeholder="₱" maxlength="2"/>
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
                          <input v-model="shop.price.short_size.black_and_white" v-on:keypress="numbersOnly" type="text" id="long_size" class="form-control-sm block w-full px-3 text-sm font-normal text-gray-700 bg-white bg-clip-padding  border border-solid border-gray-300 rounded transition ease-in-out m-0  focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" placeholder="₱" maxlength="2"/>
                        </div>
                        <div>
                          <label for="long_size" class="form-label inline-block text-sm mb-1 text-gray-700">
                            Colored
                          </label>
                          <input v-model="shop.price.short_size.colored" v-on:keypress="numbersOnly" type="text" id="long_size" class="form-control-sm block w-full px-3 text-sm font-normal text-gray-700 bg-white bg-clip-padding  border border-solid border-gray-300 rounded transition ease-in-out m-0  focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" placeholder="₱" maxlength="2"/>
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
<script>
import { computed, ref, watch } from "@vue/runtime-core";
import { useRoute } from "vue-router";
import store from "../../store";
export default {
  setup() {
    const shop = ref({
      application: {
        id: null,
        shop_name: null,
        address: null,
        baranagay: null,
        city: null,
        zipcode: null,
      },
      status: '',
      price : {}
    });

    const route = useRoute();
    const printDocsService = ref(false);

    if (route.params.id) {
      store.dispatch("getShopDetails", route.params.id)
        .then((res) => {
          shop.value.price = computed(() => JSON.parse(store.state.shopDetails.service.price))
        })
    }

    watch(
      () => store.state.shopDetails.data,
      (newVal, oldVal) => {
        shop.value = {
          ...JSON.parse(JSON.stringify(newVal)),
        };
      }
    );

    function saveService(){
      store.dispatch('setShopService', shop.value)
        .then(() => {
          Swal.fire({
            title: 'Update service successfully!',
            icon: 'success',
            timer: 3000,
            toast: true,
            position: 'top-right',
            timerProgressBar: true,
            showConfirmButton: false
          });
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
          Swal.fire({
            title: `Shop ${shop.value.status} successfully!`,
            icon: 'success',
            timer: 3000,
            toast: true,
            position: 'top-right',
            timerProgressBar: true,
            showConfirmButton: false
          });
        })
    }

    function capitalizeFirstLetter(string) {
      return string.charAt(0).toUpperCase() + string.slice(1);
    }

    return {
      shop,
      printDocsService,
      saveService,
      numbersOnly,
      capitalizeFirstLetter,
      toggleShop
    }
  }
}
</script>
<style>
</style>
