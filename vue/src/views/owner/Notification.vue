<template>
  <div class="container">
    <h1 class="font-bold text-3xl text-gray-900 px-4 md:px-3">Notification</h1>
    <div class="text-center py-6 px-6 my-6 border shadow-sm w-2/3 mx-auto space-y-6">
      <h2 class="text-2xl font-mono">Greetings, your shop application has been approved.</h2>
      <p class="text-lg font-mono">
        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Modi, esse consequatur eaque ducimus voluptatibus nostrum distinctio est vero cum perspiciatis illum dolorum dolor cupiditate quae qui sint adipisci facilis culpa iusto temporibus voluptate odit vel ipsam nisi. Rerum voluptate, aliquam ea beatae rem voluptatem asperiores. Maiores nostrum corporis error ipsum. Iste repellendus ipsum beatae sint voluptatum sequi, at aliquid enim nisi aut reiciendis dolorem quae quo facere dignissimos sunt odit. Tempora animi et dolorem aut incidunt nobis dolor, accusamus totam provident, blanditiis ad architecto molestias itaque nam odio, quasi aspernatur. Labore quisquam consectetur laudantium iusto soluta eveniet voluptates veritatis quod!
      </p>
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
          console.log(res.data.data);
        })
    }

    return {

    }
  }
}
</script>
<style>

</style>
