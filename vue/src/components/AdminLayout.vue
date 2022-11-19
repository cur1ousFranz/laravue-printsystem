<template>
    <div class="min-h-full">
      <Disclosure as="nav" class="bg-gray-800" v-slot="{ open }">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div class="flex h-16 items-center justify-between">
            <div class="flex items-center">
              <div class="flex-shrink-0">
              </div>
              <div>
                <div class="ml-10 flex items-baseline space-x-4">
                  <router-link v-for="item in navigation"
                  :key="item.name" :to="item.to"
                  :class="[this.$route.name === item.to.name ? 'bg-gray-900 text-white' :
                  'text-gray-300 hover:bg-gray-700 hover:text-white',
                  'px-3 py-2 rounded-md text-sm font-medium']"
                  :aria-current="item.current ? 'page' :
                  undefined">{{ item.name }}
                  </router-link>
                </div>
              </div>
            </div>
            <div>
              <div class="ml-4 flex items-center md:ml-6">
                <!-- Profile dropdown -->
                <Menu as="div" class="relative ml-3">
                  <div>
                    <MenuButton class="flex max-w-xs items-center rounded-full bg-gray-800 text-sm text-white px-3 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                      <span class="sr-only">Open user menu</span>
                      ADMIN
                    </MenuButton>
                  </div>
                  <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                    <MenuItems class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                      <button @click="logout" class="w-full rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-400 hover:text-white cursor-pointer">
                        Logout
                      </button>
                    </MenuItems>
                  </transition>
                </Menu>
              </div>
            </div>
          </div>
        </div>

      </Disclosure>

      <main>
        <div class="py-6 sm:px-6 lg:px-8">
          <router-view></router-view>
        </div>
      </main>
    </div>
</template>

<script setup>
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { Bars3Icon, BellIcon, XMarkIcon } from '@heroicons/vue/24/outline'
import store from '../store'
import {useRouter} from 'vue-router'

  const router = useRouter()
  const navigation = [
    { name: 'Shop List', to : { name : 'ShopList'}},
    { name: 'Application List', to : { name : 'Application'}},
    { name: 'Transaction Report', to : { name : 'TransactionReport'}},
  ]

  function logout(){
    store.dispatch('logout')
      .then((res) => {
        router.push({name : 'Login'})
      })
  }

</script>

