<template>
  <div class="mx-auto container px-2 py-1">
    <form @submit.prevent="register" class="w-8/12 mx-auto border shadow-md py-2 bg-white" enctype="multipart/form-data">
      <h1 class="mt-3 ml-6 text-md text-lg font-bold">Shop Registration</h1>
      <div class="container mx-auto flex flex-col md:flex-row space-x-2">
        <!-- first row -->
        <div class="container w-6/12 px-6 py-4 space-y-6">
          <div class="mb-2 flex space-x-3 ">

            <div class="w-full">
              <input v-model="model.first_name" type="text" id="first_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm block w-full p-2.5 focus:border-current focus:ring-0" placeholder="First Name"/>
            </div>

            <div class="w-full">
              <input v-model="model.middle_name" type="text" id="middle_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm block w-full p-2.5 focus:border-current focus:ring-0" placeholder="Middle Name (optional)"/>
            </div>

          </div>
          <div class="mb-2 flex space-x-3">

            <div class="w-full">
              <input v-model="model.last_name" type="text" id="last_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm block w-full p-2.5 focus:border-current focus:ring-0" placeholder="Last Name"/>
            </div>

            <div class="w-full">
              <input v-model="model.contact_number" type="tel" id="contact_number" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm block w-full p-2.5 focus:border-current focus:ring-0" placeholder="Contact Number"/>
            </div>

          </div>

          <div class="mb-2">
            <input v-model="model.contact_email" type="email" id="contact_email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm block w-full p-2.5 focus:border-current focus:ring-0" placeholder="Contact Email"/>
          </div>

          <div class="mb-2">
            <input v-model="model.username" type="text" id="username" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm block w-full p-2.5 focus:border-current focus:ring-0" placeholder="Username"/>
          </div>

          <div class="mb-2 flex space-x-3">

            <div class="w-full">
              <input v-model="model.password" type="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm block w-full p-2.5 focus:border-current focus:ring-0" placeholder="Password"/>
            </div>

            <div class="w-full">
              <input v-model="model.password_confirmation" type="password" id="password_confirmation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm block w-full p-2.5 focus:border-current focus:ring-0" placeholder="Confirm Password"/>
            </div>

          </div>
        </div>

        <!-- second row -->
        <div class="container w-6/12 px-6 py-4 space-y-6">

          <div class="mb-2">
            <input v-model="model.shop_name" type="text" id="shop_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm block w-full p-2.5 focus:border-current focus:ring-0" placeholder="Shop Name"/>
          </div>

          <div class="mb-2">
            <input v-model="model.address" type="text" id="address" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm block w-full p-2.5 focus:border-current focus:ring-0" placeholder="Address"/>
          </div>

          <div class="mb-2">
            <input v-model="model.barangay" type="text" id="barangay" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm block w-full p-2.5 focus:border-current focus:ring-0" placeholder="Barangay"/>
          </div>

          <div class="mb-2">
            <input v-model="model.city" type="text" id="city" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm block w-full p-2.5 focus:border-current focus:ring-0" placeholder="City"/>
          </div>

          <div class="mb-2">
            <input v-model="model.zipcode" type="text" id="zipcode" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm block w-full p-2.5 focus:border-current focus:ring-0" placeholder="Zip Code"/>
          </div>

        </div>

      </div>
      <!-- IMAGES -->
      <div class="container flex justify-around space-x-6 my-3 px-6">
        <div>
          <label for="file" class="cursor-pointer flex">
            Business Permit
          </label>
          <input @change="permitChoose" type="file" id="file" class="w-full">
        </div>

        <div>
          <label for="file" class="cursor-pointer flex">
            Valid ID
          </label>
          <input @change="validIdChoose" type="file" id="file" class="w-full">
        </div>

        <div>
          <label for="file" class="cursor-pointer flex">
           Photo of Face
          </label>
          <input @change="faceChoose" type="file" id="file" class="w-full">
        </div>

      </div>
      <div class="flex justify-end px-6 py-2">
        <Button class="float-start">
          Apply
        </Button>
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
      first_name : null,
      middle_name : null,
      last_name : null,
      contact_number : null,
      contact_email : null,
      username : null,
      password : null,
      password_confirmation : null,
      shop_name : null,
      address : null,
      barangay : null,
      city : null,
      zipcode : null,
      permit_image : null,
      valid_id_image : null,
      face_image : null,

    })

    function register(){
      const formData = new FormData()
      formData.append('first_name', model.value.first_name)
      formData.append('middle_name', model.value.middle_name)
      formData.append('last_name', model.value.last_name)
      formData.append('contact_number', model.value.contact_number)
      formData.append('contact_email', model.value.contact_email)
      formData.append('username', model.value.username)
      formData.append('password', model.value.password)
      formData.append('password_confirmation', model.value.password_confirmation)
      formData.append('shop_name', model.value.shop_name)
      formData.append('address', model.value.address)
      formData.append('barangay', model.value.barangay)
      formData.append('city', model.value.city)
      formData.append('zipcode', model.value.zipcode)
      formData.append('permit_image', model.value.permit_image)
      formData.append('valid_id_image', model.value.valid_id_image)
      formData.append('face_image', model.value.face_image)

      store.dispatch('registerOwner', formData)
        .then((res) => {
          router.push({ name : 'Shop'})
        })
    }

    function permitChoose(e) {
        const file = e.target.files[0]
        model.value.permit_image = file
    }

    function validIdChoose(e) {
        const file = e.target.files[0]
        model.value.valid_id_image = file
    }

    function faceChoose(e) {
        const file = e.target.files[0]
        model.value.face_image = file
    }

    return {
      model,
      register,
      permitChoose,
      validIdChoose,
      faceChoose,
    }
  }
}
</script>
<style>

</style>
