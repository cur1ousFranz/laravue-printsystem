<template>
  <div class="container mx-auto py-3 w-10/12 my-4 md:w-4/12">
    <form @submit.prevent="register" class="border space-y-6 px-6 py-6 shadow-md bg-white">
      <h1 class="font-bold text-2xl text-gray-900">Register</h1>

      <div class="flex space-x-3">
        <input v-model="model.first_name" id="first_name" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm block w-full p-2.5 focus:border-current focus:ring-0" placeholder="First Name"/>

        <input v-model="model.middle_name" id="middle_name" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm block w-full p-2.5 focus:border-current focus:ring-0" placeholder="Middle Name"/>
      </div>

      <div class="flex space-x-3">
        <input v-model="model.last_name"  id="last_name" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm block w-full p-2.5 focus:border-current focus:ring-0" placeholder="Last Name"/>

        <input v-model="model.username" id="username" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm block w-full p-2.5 focus:border-current focus:ring-0" placeholder="Username"/>

      </div>

      <div class="flex bg-gray-50 border border-gray-300 text-gray-900 text-sm w-full px-2 focus:border-current focus:ring-0">
        <span class="my-3 font-semibold text-gray-600"><h1>+63</h1></span>
        <input v-model="model.contact_number" v-on:keypress="numbersOnly" class="border-0 bg-gray-50 focus:ring-0 w-full" type="tel" placeholder="Mobile Number" maxlength="10">
      </div>

      <input v-model="model.password" type="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm block w-full p-2.5 focus:border-current focus:ring-0" placeholder="Password">

      <input v-model="model.password_confirmation" type="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm block w-full p-2.5 focus:border-current focus:ring-0" placeholder="Confirm Password">

      <div class="flex justify-between">
        <router-link :to="{ name : 'RegisterOwner'}" class="text-sm text-blue-600 underline">Register as Shop Owner</router-link>
        <Button>Register</Button>
      </div>
    </form>
  </div>
</template>

<script>
import store from '../../store'
import { useRouter } from 'vue-router'
import  Button  from '../../components/Button.vue'
import { ref } from '@vue/reactivity'
import { alert } from '../../alert.js'
export default {
  components : { Button },
  setup() {

    const router = useRouter()
    const model = ref({
      first_name : '',
      middle_name : '',
      last_name : '',
      username : '',
      contact_number : '',
      password : '',
      password_confirmation : '',
    })

    function register(){

        const formData = new FormData()
        formData.append('first_name', model.value.first_name)
        formData.append('middle_name', model.value.middle_name)
        formData.append('last_name', model.value.last_name)
        formData.append('contact_number', model.value.contact_number)
        formData.append('username', model.value.username)
        formData.append('password', model.value.password)
        formData.append('password_confirmation', model.value.password_confirmation)

        store.dispatch('register', formData)
          .then((res) => {
            router.push({ name : 'VerifyMobile'})
          })
          .catch((res) =>{
            alert('Invalid mobile number', 'error')
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
      register,
      numbersOnly,
    }
  }
}
</script>
<style>

</style>
