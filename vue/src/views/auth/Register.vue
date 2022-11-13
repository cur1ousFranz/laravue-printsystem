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

      <input v-model="model.contact_email" type="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm block w-full p-2.5 focus:border-current focus:ring-0" placeholder="Email" required="">

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
export default {
  components : { Button },
  setup() {

    const router = useRouter()
    const model = ref({
      first_name : '',
      middle_name : '',
      last_name : '',
      username : '',
      contact_email : '',
      password : '',
      password_confirmation : '',
    })

    function register(){
      const formData = new FormData()
      formData.append('first_name', model.value.first_name)
      formData.append('middle_name', model.value.middle_name)
      formData.append('last_name', model.value.last_name)
      formData.append('contact_email', model.value.contact_email)
      formData.append('username', model.value.username)
      formData.append('password', model.value.password)
      formData.append('password_confirmation', model.value.password_confirmation)

      store.dispatch('register', formData)
        .then((res) => {
          router.push({ name : 'Home'})
        })
    }

    return { model, register }
  }
}
</script>
<style>

</style>
