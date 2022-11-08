<template>
  <div class="container mx-auto py-3 w-10/12 my-4 md:w-4/12">
    <form @submit.prevent="register" class="border space-y-3 px-6 py-6 shadow-md bg-white">
      <h1 class="font-bold text-2xl text-gray-900">Register</h1>
      <div class="mb-6">
        <label for="username" class="block mb-2 text-sm font-medium text-gray-900">Username
        </label>
        <input v-model="model.username" type="text" id="username" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Username"/>
      </div>
      <div class="mb-6">
          <label for="email" class="block mb-2 text-sm font-medium text-gray-900">
            Email
          </label>
          <input v-model="model.contact_email" type="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Email" required="">
      </div>
      <div class="mb-6">
          <label for="pasword" class="block mb-2 text-sm font-medium text-gray-900">
            Pasword
          </label>
          <input v-model="model.password" type="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="********">
      </div>
      <div class="mb-6">
          <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900">
            Password Confirmation
          </label>
          <input v-model="model.password_confirmation" type="password" id="password_confirmation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="********">
      </div>
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
export default {
  components : { Button },
  setup() {

    const router = useRouter()
    const model = {
      username : '',
      contact_email : '',
      password : '',
      password_confirmation : '',
    }

    function register(){
      store.dispatch('register', model)
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
