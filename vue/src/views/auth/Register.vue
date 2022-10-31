<template>
  <div class="container mx-auto py-3 w-10/12 my-4 md:w-4/12">
    <form @submit.prevent="register" class="border space-y-3 px-3 rounded-md py-6 shadow-md">
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
        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Register</button>
      </div>
    </form>
  </div>
</template>

<script>
import store from '../../store'
import { useRouter } from 'vue-router'
export default {
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
