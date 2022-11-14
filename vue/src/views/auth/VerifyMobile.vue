<template>
  <div class="container mx-auto py-3 w-10/12 my-4 md:w-4/12">
    <form @submit.prevent="verify" class="border space-y-6 px-6 py-6 shadow-md bg-white">
      <h1 class="font-bold text-2xl text-gray-900">SMS Verification</h1>

      <input v-model="model.code" v-on:keypress="numbersOnly" id="first_name" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm block w-full p-2.5 focus:border-current focus:ring-0" placeholder="Enter code" maxlength="6"/>

      <div class="flex justify-end">
        <Button>Send</Button>
      </div>
    </form>
  </div>
</template>
<script>
import { ref } from '@vue/reactivity'
import  Button  from '../../components/Button.vue'
import store from '../../store'
import { useRoute, useRouter } from 'vue-router'
import { alert } from '../../alert.js'
export default {
  components : { Button },
  setup(){

    const router = useRouter()
    const route = useRoute()
    const model = ref({
      code : null
    })

    if(sessionStorage.getItem('USER_ID')){
      alert('Verification sent!')
    }

    if(!sessionStorage.getItem('USER_ID')){
      router.push({ name : 'Login'})
    }

    function verify(){
      const formData = new FormData()
      formData.append('code', model.value.code)
      formData.append('user_id', sessionStorage.getItem('USER_ID'))
      store.dispatch('verifyCode', formData)
        .then((res) => {
          alert('Account created!')
          setTimeout(() => {
            router.push({ name : 'Home'})
          }, 2000)
        })
        .catch((res) => {
           alert('Invalid code', 'error')
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

    return {
      model,
      verify,
      numbersOnly
    }
  }
}
</script>
<style>

</style>
