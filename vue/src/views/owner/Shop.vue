<template>

  <div class="mx-auto max-w-7xl sm:px-6 lg:px-4">
    <h1 class="font-bold text-3xl text-gray-900 px-4 md:px-3">Shop</h1>
    <div class="px-4 py-4 sm:px-0">
      <div class="h-full rounded-lg border-4 border-dashed border-gray-200 px-6 py-6">
        <div v-if="loadStatus" class="flex justify-center py-44">
          Loading..
        </div>
        <div v-else>
          <div v-if="shops.length" >
            <div v-for="shop in shops" :key="shop.id" class="max-w-xs bg-white rounded-lg border border-gray-200 shadow-md">
                <a href="#">
                    <img class="rounded-t-lg" src="https://flowbite.com/docs/images/blog/image-1.jpg" alt="" />
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
                    <Button class="flex">
                       View
                      <svg aria-hidden="true" class="ml-2 mt-1 -mr-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                      </svg>
                    </Button>
                  </router-link>
                </div>
            </div>
          </div>
          <div v-else class="container w-full text-center py-44 text-gray-400 text-2xl font-bold">
              Nothing to show
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
  setup() {

    store.dispatch('getOwnerShops')

    const shops = computed(() => store.state.ownerShops.data)
    const loadStatus = computed(() => store.state.ownerShops.loading)

    function capitalizeFirstLetter(string) {
      return string.charAt(0).toUpperCase() + string.slice(1);
    }

    return { shops, loadStatus, capitalizeFirstLetter }
  }
}
</script>
<style>

</style>
