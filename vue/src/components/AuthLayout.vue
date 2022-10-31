<template>
    <div class="min-h-full">
      <nav class="bg-gray-900 py-5 flex justify-between px-14">
        <div>

        </div>
        <div class="flex space-x-3 text-white">
          <router-link :to="{ name : 'Register'}">Register</router-link>
          <router-link :to="{ name : 'Login'}">Login</router-link>
        </div>
      </nav>
      <router-view></router-view>
    </div>
</template>

<script setup>
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { Bars3Icon, BellIcon, XMarkIcon } from '@heroicons/vue/24/outline'
import store from '../store'
import {useRouter} from 'vue-router'

const router = useRouter()

const user = {
  name: 'Tom Cook',
  email: 'tom@example.com',
  imageUrl:
    'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
  }

  const navigation = [
    { name: 'Home', to : { name : 'Home'}, current: true },
    { name: 'Team', href: '#', current: false },
  ]

  function logout(){
    store.dispatch('logout')
      .then((res) => {
        router.push({name : 'Login'})
      })
  }

</script>

