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
                  :class="[$route.name === item.to.name ? 'bg-gray-900 text-white' :
                  'text-gray-300 hover:bg-gray-700 hover:text-white',
                  'px-3 py-2 rounded-md text-sm font-medium']"
                  :aria-current="item.current ? 'page' :
                  undefined">{{ item.name }}
                  </router-link>
                </div>
              </div>
            </div>

            <div >

              <div  v-if="notifications.notifications" class="ml-4 flex items-center md:ml-6">

                <!-- Notifications -->
                <Menu v-if="notifications.notifications.length != 0" as="div" class="relative ml-3">
                  <MenuButton class="flex max-w-xs items-center rounded-full bg-gray-800 text-sm text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                    <BellIcon class="h-6 w-6" aria-hidden="true"/>
                      <span v-if="notifications.unread.length != 0" class="absolute inline-block top-0 right-0 p-1.5 text-xs bg-red-500 rounded-full z-10">
                      </span>
                  </MenuButton>

                  <MenuItems>
                    <MenuItem v-for="unread in notifications.unread" :key="unread.id" class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-green-200 py-4 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none px-3">
                      <router-link :to="{ name : 'CustomerNotification', params : { id: unread.id }}">
                        <div v-if="unread.data.title">
                          <p class="font-semibold text-gray-600">
                            {{ unread.data.title }}
                          </p>
                          <div class="flex justify-end mt-2">
                            <p class="text-xs">{{ formatDateUS(unread.created_at) }}</p>
                          </div>
                        </div>
                      </router-link>
                    </MenuItem>

                    <MenuItem v-for="read in notifications.read" :key="read.id" class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-gray-100 py-4 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none px-3">
                      <router-link :to="{ name : 'CustomerNotification', params : { id: read.id }}">
                        <div v-if="read.data.title">
                          <p class="font-semibold text-sm text-gray-600">
                            {{ read.data.title }}
                          </p>
                          <div class="flex justify-end mt-2">
                            <p class="text-xs">{{ formatDateUS(read.created_at) }}</p>
                          </div>
                        </div>
                      </router-link>
                    </MenuItem>
                  </MenuItems>
                </Menu>

                <!-- Zero Notifications -->
                <Menu v-if="notifications.notifications.length == 0" as="div" class="relative ml-3">
                    <MenuButton class="flex max-w-xs items-center rounded-full bg-gray-800 text-sm text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                      <span class="sr-only">View notifications</span>
                      <BellIcon class="h-6 w-6" aria-hidden="true" />
                    </MenuButton>

                    <MenuItems>
                        <MenuItem class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-4 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none px-3">
                            <h2>Nothing to show</h2>
                      </MenuItem>
                    </MenuItems>
                </Menu>

                <!-- Profile dropdown -->
                <Menu as="div" class="relative ml-3">
                  <div>
                    <MenuButton class="flex max-w-xs items-center rounded-full text-white bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                      <span class="sr-only">Open user menu</span>
                      CUSTOMER
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
        <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
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
import { ref } from '@vue/reactivity'
import { onMounted } from '@vue/runtime-core'

const router = useRouter()
const notifications = ref({})

  const navigation = [
    { name: 'Home', to : { name : 'Home'}},
    { name: 'Transactions', to : { name : 'Transaction'}},
  ]

  store.dispatch('getOwnerNotifications')
    .then((res) => {
      notifications.value = res.data.data
  })

  function logout(){
    store.dispatch('logout')
      .then((res) => {
        router.push({name : 'Login'})
      })
  }

  function formatDateUS(date) {
    const options = { year: 'numeric', month: 'numeric', day: 'numeric'}
    return new Date(date).toLocaleDateString('en-US', options)
  }

  onMounted(async () => {
    const data = await store.dispatch('isUserAuth')
    console.log(data);
  })

</script>

<style scoped>
.dropdown:hover .dropdown-menu {
  display: block;
}
</style>
