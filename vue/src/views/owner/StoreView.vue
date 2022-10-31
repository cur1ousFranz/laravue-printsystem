<template>
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-4">
      <div class="overflow-x-auto relative">
        <pre>{{ shop }}</pre>
      </div>
  </div>
</template>
<script>
import { computed } from '@vue/runtime-core'
import { useRoute } from 'vue-router'
import store from '../../store'
export default {
  setup(){
    const route = useRoute()

    const shop = computed(() => store.state.shopDetails.data)
    store.dispatch('getShopDetails', route.params.id)

    return { shop }
  }
}
</script>
<style>

</style>
