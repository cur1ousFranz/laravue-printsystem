<template>
  <div class="mx-auto container px-2 py-6">
    <form @submit.prevent="register" class="border rounded-md shadow-md py-2">
      <h1 class="mt-4 ml-6 text-md text-lg font-bold">Register as Shop Owner</h1>
      <div class="container mx-auto flex flex-col md:flex-row space-x-3">
        <!-- first row -->
        <div class="container w-6/12 px-6 py-6">
          <div class="mb-4 flex space-x-3">
            <div class="w-full">
              <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900">First Name
              </label>
              <input v-model="model.first_name" type="text" id="first_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="First Name"/>
            </div>
            <div class="w-full">
              <label for="middle_name" class="block mb-2 text-sm font-medium text-gray-900">Middle Name (Optional)
              </label>
              <input v-model="model.middle_name" type="text" id="middle_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Middle Name"/>
            </div>
          </div>
          <div class="mb-4 flex space-x-3">
            <div class="w-full">
              <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900">Last Name
              </label>
              <input v-model="model.last_name" type="text" id="last_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Last Name"/>
            </div>
            <div class="w-full">
              <label for="contact_number" class="block mb-2 text-sm font-medium text-gray-900">Contact Number
              </label>
              <input v-model="model.contact_number" type="tel" id="contact_number" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Contact Number"/>
            </div>
          </div>

          <div class="mb-4">
            <label for="contact_email" class="block mb-2 text-sm font-medium text-gray-900">Contact Email
            </label>
            <input v-model="model.contact_email" type="email" id="contact_email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Contact Email"/>
          </div>
          <div class="mb-4">
            <label for="username" class="block mb-2 text-sm font-medium text-gray-900">Username
            </label>
            <input v-model="model.username" type="text" id="username" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Username"/>
          </div>
          <div class="mb-4 flex space-x-3">
            <div class="w-full">
              <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password
              </label>
              <input v-model="model.password" type="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="********"/>
            </div>
            <div class="w-full">
              <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900">Confirm Password
              </label>
              <input v-model="model.password_confirmation" type="password" id="password_confirmation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="********"/>
            </div>
          </div>
        </div>

        <!-- second row -->
        <div class="container w-6/12 px-6 py-6">
          <div class="mb-4">
            <label for="shop_name" class="block mb-2 text-sm font-medium text-gray-900">Shop Name
            </label>
            <input v-model="model.shop_name" type="text" id="shop_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Shop Name"/>
          </div>
          <div class="mb-4">
          <label for="address" class="block mb-2 text-sm font-medium text-gray-900">Address
            </label>
            <input v-model="model.address" type="text" id="address" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Address"/>
          </div>
          <div class="mb-4">
          <label for="barangay" class="block mb-2 text-sm font-medium text-gray-900">Barangay
            </label>
            <input v-model="model.barangay" type="text" id="barangay" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Barangay"/>
          </div>
          <div class="mb-4">
            <label for="city" class="block mb-2 text-sm font-medium text-gray-900">City
            </label>
            <input v-model="model.city" type="text" id="city" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg text:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="City"/>
          </div>
          <div class="mb-4">
            <label for="zipcode" class="block mb-2 text-sm font-medium text-gray-900">Zip Code
            </label>
            <input v-model="model.zipcode" type="text" id="zipcode" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Zip Code"/>
          </div>
        </div>
      </div>
      <div class="flex justify-end px-6">
        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Apply</button>
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
      first_name : '',
      middle_name : '',
      last_name : '',
      contact_number : '',
      contact_email : '',
      username : '',
      password : '',
      password_confirmation : '',
      shop_name : '',
      address : '',
      barangay : '',
      city : '',
      zipcode : '',
    }

    function register(){
      store.dispatch('registerOwner', model)
        .then((res) => {
          router.push({ name : 'Shop'})
        })
    }

    return { model, register }
  }
}
</script>
<style>

</style>
