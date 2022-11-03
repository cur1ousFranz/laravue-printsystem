<template>





</template>
<script>
import { computed } from '@vue/runtime-core'
import store from '../../store'
import { useRoute } from "vue-router";
export default {
  setup(){

    const route = useRoute()

    store.dispatch('getCustomerShopDetails', route.params.id)

    return {  }
  }
}
</script>
<style>

</style>
