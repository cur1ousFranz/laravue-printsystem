<template>
  <div class="mx-auto container px-2 py-1">
    <form @submit.prevent="register" class="w-8/12 mx-auto border-gray-900 border-t-2 border-b-2 shadow-md py-2 bg-white" enctype="multipart/form-data">
      <h1 class="mt-3 ml-6 text-md text-lg font-bold">Shop Registration</h1>
      <div class="container mx-auto flex flex-col md:flex-row space-x-2">
        <!-- first row -->
        <div class="container w-6/12 px-6 py-4 space-y-6">
          <div class="mb-2 flex space-x-3 ">

            <div class="w-full">
              <input v-model="model.first_name" type="text" id="first_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm block w-full p-2.5 focus:border-current focus:ring-0" placeholder="First Name" required/>
            </div>

            <div class="w-full">
              <input v-model="model.middle_name" type="text" id="middle_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm block w-full p-2.5 focus:border-current focus:ring-0" placeholder="Middle Name (optional)"/>
            </div>

          </div>

          <div class="mb-2">
            <input v-model="model.last_name" type="text" id="last_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm block w-full p-2.5 focus:border-current focus:ring-0" placeholder="Last Name" required/>
          </div>

        <div class="flex bg-gray-50 border h-10 border-gray-300 text-gray-900 text-sm w-full px-2 focus:border-current focus:ring-0">
          <span class="my-2.5 font-semibold text-gray-600"><h1>+63</h1></span>
          <input v-model="model.contact_number" v-on:keypress="numbersOnly" class="border-0 bg-gray-50 focus:ring-0 w-full" type="tel" placeholder="Mobile Number (ex. 9xxxxxxxxx)" maxlength="10" required>
        </div>

          <div class="mb-2">
            <input v-model="model.username" type="text" id="username" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm block w-full p-2.5 focus:border-current focus:ring-0" placeholder="Username" required/>
          </div>

          <div class="mb-2 flex space-x-3">

            <div class="w-full relative">
              <input v-model="model.password" type="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm block w-full p-2.5 focus:border-current focus:ring-0" placeholder="Password" required maxlength="16"/>
              <p class="text-sm text-red-500 absolute">{{ password }}</p>
            </div>

            <div class="w-full relative">
              <input v-model="model.password_confirmation" type="password" id="password_confirmation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm block w-full p-2.5 focus:border-current focus:ring-0" placeholder="Confirm Password" required maxlength="16"/>
              <p class="text-sm text-red-500 absolute">{{ confirmPassword }}</p>
            </div>

          </div>
        </div>

        <!-- second row -->
        <div class="container w-6/12 px-6 py-4 space-y-6">

          <div class="mb-2">
            <input v-model="model.shop_name" type="text" id="shop_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm block w-full p-2.5 focus:border-current focus:ring-0" placeholder="Shop Name" required/>
          </div>

          <div class="mb-2">
            <input v-model="model.address" type="text" id="address" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm block w-full p-2.5 focus:border-current focus:ring-0" placeholder="Address" required/>
          </div>

          <div class="mb-2">
            <input v-model="model.barangay" type="text" id="barangay" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm block w-full p-2.5 focus:border-current focus:ring-0" placeholder="Barangay" required/>
          </div>

          <div class="mb-2">
            <input v-model="model.city" type="text" id="city" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm block w-full p-2.5 focus:border-current focus:ring-0" placeholder="City" required/>
          </div>

          <div class="mb-2">
            <input v-model="model.zipcode" type="text" id="zipcode" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm block w-full p-2.5 focus:border-current focus:ring-0" placeholder="Zip Code" required/>
          </div>

        </div>

      </div>
      <!-- IMAGES -->
      <div class="container flex justify-around space-x-6 my-6 px-6">
        <div>
          <label for="file" class="cursor-pointer flex">
            Business Permit
          </label>
          <input @change="permitChoose" type="file" accept="image/*" class="w-full" required>
        </div>

        <div>
          <label for="file" class="cursor-pointer flex">
            Valid ID
          </label>
          <input @change="validIdChoose" type="file" accept="image/*" class="w-full" required>
        </div>

        <div>
          <label for="file" class="cursor-pointer flex">
           Photo of Face
          </label>
          <input @change="faceChoose" type="file" accept="image/*" class="w-full" required>
        </div>
      </div>
      <div class="container space-x-6 my-3 px-6">
        <p class="text-sm">IMPORTANT:
          Attach a 2x2 size picture of yourself. It should have full face, front view, eyes open. Photo should present full head from top of hair to bottom of chin.
        </p>
      </div>
      <div class="flex justify-end px-6 py-2">
        <Button :disabled="loadStatus ? true : false" class="flex">
          Apply
            <!-- <span v-if="loadStatus">
              <svg aria-hidden="true" class="ml-2 w-4 h-4 my-1 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
              </svg>
            </span> -->
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
import { computed } from '@vue/runtime-core'
import { alert } from '../../alert.js'
export default {
  components : { Button },
  setup() {

    const password = ref('')
    const confirmPassword = ref('')
    let loadStatus = computed(() => store.state.user.loading)
    const router = useRouter()
    const model = ref({
      first_name : null,
      middle_name : null,
      last_name : null,
      contact_number : null,
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
      confirmPassword.value = ''
      password.value = ''

      const formData = new FormData()
      formData.append('first_name', model.value.first_name)
      formData.append('middle_name', model.value.middle_name)
      formData.append('last_name', model.value.last_name)
      formData.append('contact_number', model.value.contact_number)
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
          router.push({ name : 'VerifyMobile'})
        })
        .catch((res) => {
          res.response.data.errors.password.forEach(element => {
            if(element === 'The password must be at least 8 characters.'){
              password.value = element
            }

            if(element === 'The password confirmation does not match.'){
              confirmPassword.value = element
            }
          });
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
      loadStatus,
      register,
      permitChoose,
      validIdChoose,
      faceChoose,
      confirmPassword,
      password
    }
  }
}
</script>
