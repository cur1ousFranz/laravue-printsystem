<template>
  <div class="mx-auto max-w-7xl sm:px-6 lg:px-4">
    <h1 class="font-bold text-3xl text-gray-900 px-4 md:px-3">All Shops</h1>
    <div class="px-4 py-4 sm:px-0">
      <pre>{{ shops }}</pre>
    </div>

  </div>
</template>
<script>
import { computed } from '@vue/runtime-core'
import store from '../../store'
export default {
  setup(){

    store.dispatch('getAllShops')
    const shops = computed(() => store.state.allShops.data)

    return {
      shops,
    }
  }
}
</script>
