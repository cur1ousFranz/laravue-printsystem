<template>
  <div class="container">
    <h1 class="font-bold text-3xl text-gray-900 px-4 md:px-3">Notification</h1>
    <div class="text-center py-6 px-6 my-6 border-gray-900 border-t-2 border-b-2 shadow-sm w-2/3 mx-auto space-y-6">
      <h2 class="text-2xl font-mono">Greetings, your shop application has been approved.</h2>
      <div class="px-12">
        <p class="text-lg font-mono py-12 border bg-gray-300">
          You can now setup your shop to add services.
        </p>
      </div>
    </div>
  </div>
</template>

<script>
import { useRoute } from "vue-router";
import store from '../../store';
export default {
  setup(){

    const route = useRoute()

    if(route.params.id){
      store.dispatch('getNotificationDetails', route.params.id)
        .then((res) => {
          // console.log(res.data.data);
        })
    }

    return {

    }
  }
}
</script>
<style>

</style>
