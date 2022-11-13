<template>
  <div class="flex flex-col px-32 py-12 md:flex-row">
    <div class="hidden container px-6 space-y-4 py-6 md:block">
      <h1 class="text-5xl font-bold text-white uppercase">Printing Services</h1>
      <h1 class="text-3xl text-white">
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt, dicta.
      </h1>
      <Button>Learn more</Button>
    </div>
    <div class="container flex justify-center md:justify-end">

      <form @submit.prevent="login" class="h-fit border space-y-6 px-3 py-6 shadow-md bg-white md:w-8/12">
        <h1 class="font-bold text-2xl text-gray-900">Login</h1>

        <input v-model="model.username" type="text" id="username" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm block w-full p-2.5 focus:border-current focus:ring-0" placeholder="Username" required="">

        <input v-model="model.password" type="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm block w-full p-2.5 focus:border-current focus:ring-0" placeholder="Password">

        <div class="flex items-start mb-6">
            <div class="flex items-center h-5">
            <input v-model="model.remember" id="remember" type="checkbox" value="" class="w-4 h-4 bg-gray-50 rounded border border-gray-300 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800">
            </div>
            <label for="remember" class="ml-2 text-sm font-medium text-gray-900">
              Remember me
            </label>
        </div>

        <div class="flex justify-end">
          <Button>
            Login
            <span v-if="loadStatus">...</span>
          </Button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue'
import store from '../../store'
import { useRouter } from 'vue-router'
import { computed, ref } from '@vue/runtime-core'
import  Button  from '../../components/Button.vue'
import  InputField  from '../../components/InputField.vue'
export default {
  components : { Button, InputField },
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
          router.push({ name : 'Shop'})
        }

        if(store.state.user.role === 'admin'){
          router.push({ name : 'ShopList'})
        }
      })
      .catch(() => {
        loadStatus.value = false
      })
  }

  const isOpen = ref(false)

  function setIsOpen(value) {
    isOpen.value = value
  }

    return {
      model,
      loadStatus,
      login,
      isOpen,
      setIsOpen
    }
  }
}
</script>
