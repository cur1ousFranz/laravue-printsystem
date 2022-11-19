<template>
  <div class="mx-auto max-w-7xl sm:px-6 lg:px-4">
    <h1 class="font-bold text-3xl text-gray-900 px-4 md:px-3">All Shops</h1>
    <div v-if="loadStatus" class="flex justify-center py-44">
      <svg aria-hidden="true" class="ml-2 w-10 h-10 my-1 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
      </svg>
    </div>
    <div v-else class="px-4 py-4 sm:px-0">
      <div v-if="shops.length" class="grid grid-cols-1 place-items-center sm:grid-cols-2 sm:space-x-3 md:grid-cols-3">
        <div v-for="shop in shops" :key="shop.id" class="max-w-xs bg-white border-gray-900 border-t-2 border-b-2 hover:shadow-xl">
            <a href="#">
                <img :src="shop.image ? shop.image  : '/img/default-shop-img.jpg'" alt="" />
            </a>
            <div class="px-4 py-3">
              <div class="flex justify-between">
                <p class="my-2 text-lg font-semibold text-gray-900" style="letter-spacing: 1px">
                  {{ shop.application.shop_name }}
                </p>
                <p :class="[shop.status === 'close' ? 'my-1 text-sm font-bold text-red-500 px-2 py-1 rounded-md' :
          'my-1 text-sm font-bold text-green-500 px-2 py-1 rounded-md']">
                  {{ capitalizeFirstLetter(shop.status) }}
                </p>
              </div>
              <p class="mb-3 text-sm font-semibold text-gray-900" style="letter-spacing: 1px">
                {{ shop.application.address }} , {{ shop.application.barangay }} , {{ shop.application.city }}, {{ shop.application.zipcode }}
              </p>
              <router-link :to="{ name : 'ShopView', params : { id : shop.id}}">
                <!-- <Button class="flex py-1">
                    View
                  <svg aria-hidden="true" class="ml-2 mt-1 -mr-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                  </svg>
                </Button> -->
              </router-link>
            </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { computed } from '@vue/runtime-core'
import store from '../../store'
import  Button  from '../../components/Button.vue'
export default {
  components : { Button },
  setup(){

    store.dispatch('getAllShops')
    const shops = computed(() => store.state.allShops.data)
    const loadStatus = computed(() => store.state.allShops.loading)

    function capitalizeFirstLetter(string) {
      return string.charAt(0).toUpperCase() + string.slice(1);
    }

    return {
      shops,
      loadStatus,
      capitalizeFirstLetter,
    }
  }
}
</script>
