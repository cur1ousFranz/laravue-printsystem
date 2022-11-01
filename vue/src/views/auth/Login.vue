<template>
  <div class="container mx-auto py-3 w-10/12 my-4 md:w-4/12">

    <form @submit.prevent="login" class="border space-y-4 px-3 rounded-md py-6 shadow-md">
      <h1 class="font-bold text-2xl text-gray-900">Login</h1>

      <div class="mb-6">
          <label for="username" class="block mb-2 text-sm font-medium text-gray-900">
            Username
          </label>
          <input v-model="model.username" type="username" id="username" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Username" required="">
      </div>
      <div class="mb-6">
          <label for="pasword" class="block mb-2 text-sm font-medium text-gray-900">
            Pasword
          </label>
          <input v-model="model.password" type="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="********">
      </div>

      <div class="flex items-start mb-6">
          <div class="flex items-center h-5">
          <input v-model="model.remember" id="remember" type="checkbox" value="" class="w-4 h-4 bg-gray-50 rounded border border-gray-300 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800">
          </div>
          <label for="remember" class="ml-2 text-sm font-medium text-gray-900">
            Remember me
          </label>
      </div>
      <div class="flex justify-end">
        <button type="submit" :class="[ loadStatus ? 'text-white bg-blue-400 focus:outline-none  font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:hover:bg-blue-700 '
        : 'text-white bg-blue-700 hover:bg-blue-800 focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700']">
          Login
          <span v-if="loadStatus">...</span>
        </button>
      </div>
    </form>
  </div>
</template>

<script>
import store from '../../store'
import { useRouter } from 'vue-router'
import { computed, ref } from '@vue/runtime-core'
export default {
  setup() {

    const router = useRouter()
    const model = {
      username : '',
      password : '',
      remember : false,
    }

    let loadStatus = ref(false)

    function login(){
      loadStatus.value = computed(() => store.state.user.loading)
      store.dispatch('login', model)
        .then((res) => {

          if(store.state.user.role === 'customer'){

            router.push({ name : 'Home'})
          }

          if(store.state.user.role === 'businessowner'){

            router.push({ name : 'Store'})
          }

          if(store.state.user.role === 'admin'){

            router.push({ name : 'Dashboard'})
          }

        })
        .catch(() => {
          loadStatus.value = false
        })
    }

    return { model, loadStatus, login }
  }
}
</script>
<style>

</style>

