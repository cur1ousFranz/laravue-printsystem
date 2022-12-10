<template>
  <div class="container mx-auto py-3 w-10/12 my-4 md:w-4/12">
    <form @submit.prevent="register" class="border-gray-900 border-t-2 border-b-2 space-y-6 px-6 py-6 shadow-md bg-white">
      <h1 class="font-bold text-2xl text-gray-900">Register</h1>

      <div class="flex space-x-3">
        <input v-model="model.first_name" id="first_name" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm block w-full p-2.5 focus:border-current focus:ring-0" placeholder="First Name" required/>

        <input v-model="model.middle_name" id="middle_name" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm block w-full p-2.5 focus:border-current focus:ring-0" placeholder="Middle Name (Optional)"/>
      </div>

      <div class="flex space-x-3">
        <input v-model="model.last_name"  id="last_name" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm block w-full p-2.5 focus:border-current focus:ring-0" placeholder="Last Name" required/>

        <input v-model="model.username" id="username" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm block w-full p-2.5 focus:border-current focus:ring-0" placeholder="Username" required/>

      </div>

      <div class="flex bg-gray-50 border border-gray-300 text-gray-900 h-10 text-sm w-full px-2 focus:border-current focus:ring-0">
        <span class="my-2.5 font-semibold text-gray-600"><h1>+63</h1></span>
        <input v-model="model.contact_number" v-on:keypress="numbersOnly" class="border-0 bg-gray-50 focus:ring-0 w-full" type="tel" placeholder="Mobile Number (ex. 9xxxxxxxxx)" maxlength="10" required>
      </div>

      <div>
        <input v-model="model.password" type="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm block w-full p-2.5 focus:border-current focus:ring-0" placeholder="Password" maxlength="16">
        <p class="text-sm text-red-500 absolute">{{ password }}</p>
      </div>

      <div>
        <input v-model="model.password_confirmation" type="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm block w-full p-2.5 focus:border-current focus:ring-0" placeholder="Confirm Password" required maxlength="16">
        <p class="text-sm text-red-500 absolute">{{ confirmPassword }}</p>
      </div>

      <div class="flex space-x-3">
        <input type="checkbox" class="bg-gray-50 border  border-gray-300 text-gray-900 text-sm block focus:border-current focus:ring-0" required>
        <button @click="showModal" type="button" class="text-sm underline">Terms & Condition</button>
      </div>

      <div class="flex justify-between">
        <router-link :to="{ name : 'RegisterOwner'}" class="text-sm text-blue-600 underline">Register as Shop Owner</router-link>
        <Button :disabled="loadStatus ? true : false" class="flex">
          Register
            <span v-if="loadStatus">
              <svg aria-hidden="true" class="ml-2 w-4 h-4 my-1 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
              </svg>
            </span>
        </Button>
      </div>
    </form>

    <PlainModal v-show="isModalVisible" @close="closeModal" @some-event="confirm" >
        <template v-slot:header>
          Terms & Condition
        </template>

        <template v-slot:body>
          <p>
            Please read these terms and conditions (“Terms” , “Terms and Conditions”) carefully before using the website link, website operate by Near Printer (“us”, “we”, or “our”). Please read the terms carefully.
          </p>

          <p class="mt-3">
           By accessing and using the platforms, agree that you have read, understood and accepted on the platform. If you do not agree within the terms and conditions, please do not use the website. The website may be and by (i) persons who have reached eighteen (18) years of age. Users below eighteen (18) must obtain consent from parents or guardian, Who by accepting these terms shall agree to take responsibility for your actions associated with your use of the website. If you do not have consent from your parents or guardian, you must stop using/accessing the website.
          </p>

          <h1 class="text-xl mt-6 font-semibold">
            1. Near Printer
          </h1>
          <h1 class="text-lg ml-5 mt-2">
            1.1 Who we are
          </h1>
          <p class="ml-12">
            Near Printer is an online platform established to provide an innovative printing service system.
          </p>

          <h1 class="text-lg ml-5">
            1.2 What we do
          </h1>
          <p class="ml-12">
           Through our website (platform), Near printer links you to the printing shops for you to conveniently files to be printed. This platform provides a more efficient and simple approach to print files.
          </p>

          <h1 class="text-lg ml-5">
            1.3 How to contact us
          </h1>
          <p class="ml-12">
            For customers support, you may reach out to us via email or (email address).
          </p>

          <h1 class="text-xl mt-6 font-semibold">
            2. Use of the website and Near Printer Account.
          </h1>
          <p class="ml-5 mt-2">
            2.1 You will need to register for an account for you to use the platform. When you register for an account, you are asked to provide personal information which included your full name, valid email address, phone number, and a unique password. We reserve the rights to request further information or documentation to comply with our legal obligations. To request printing your files, depending on which payment method you opt for you may need to provide us with your (Gcash) Details. Your password should not be shared with anyone.
          </p>

          <p class="ml-5 mt-2">
            2.2 You are obliged to provide complete, accurate and truthful information for the proper processing of your print request.
          </p>

          <h1 class="text-xl mt-6 font-semibold">
            3. Intellectual Property
          </h1>
          <p class="ml-5 mt-2">
            All trademarks, logos, images are the intellectual property of Near Printer. You may not use, copy, distribute or modify the trademarks without consent.
          </p>

          <h1 class="text-xl mt-6 font-semibold">
            4. Print Request
          </h1>
          <p class="ml-5 mt-2">
            You will browse for available printing shops of your choice for you to select and request to print your files. When you place a request to print your files, Near printer will confirm your request by sending you a notification containing the receipt.
          </p>

          <p class="ml-5 mt-2">
            To complete the process, you may require to provide additional details. You are required to review the details and confirm that the information provided including the amount, pick-up time details, personal details and payment an accurate and complete before you place a request.
          </p>

          <h1 class="text-xl mt-6 font-semibold">
            5. Price and Payments
          </h1>

          <p class="ml-5 mt-2">
           5.1 Prices and displayed and may vary number and size of pages, color, type of paper, and the prices of your selected printing shops.
          </p>

          <p class="ml-5 mt-2">
           5.2 You can pay for your printing request using the Gcash payment method. Once you paid the amount, you are required to save/download the receipt to be presented (or submitted) to your chose printing shop.
          </p>

         <p class="ml-5 mt-2">
           5.3 After printing request is successful placed, you will receive a notification that container a confirmation details of your request and the pick-up time of your printed files.
          </p>

          <p class="ml-5 mt-2">
            The platform may container third party apps to complete the process of printing your request. Near Printer does not control the third-party app and shall not be liable or responsible for any loss in relation to your access and use.
          </p>

        </template>

        <template v-slot:footer>
          This is a new modal footer.
        </template>
      </PlainModal>
  </div>
</template>

<script>
import store from '../../store'
import { useRouter } from 'vue-router'
import  Button  from '../../components/Button.vue'
import { ref } from '@vue/reactivity'
import { alert } from '../../alert.js'
import { computed } from '@vue/runtime-core'
import PlainModal from '../../components/PlainModal.vue'
export default {
  components : { Button, PlainModal },
  setup() {

    const password = ref('')
    const confirmPassword = ref('')
    const isModalVisible = ref(false)
    let loadStatus = computed(() => store.state.user.loading)
    const router = useRouter()
    const model = ref({
      first_name : '',
      middle_name : '',
      last_name : '',
      username : '',
      contact_number : '',
      password : '',
      password_confirmation : '',
    })

    if(sessionStorage.getItem('USER_ID')){
      router.push({ name : 'VerifyMobile'})
    }

    function register(){
      password.value = ''
      confirmPassword.value = ''
      const formData = new FormData()
      formData.append('first_name', model.value.first_name)
      formData.append('middle_name', model.value.middle_name)
      formData.append('last_name', model.value.last_name)
      formData.append('contact_number', model.value.contact_number)
      formData.append('username', model.value.username)
      formData.append('password', model.value.password)
      formData.append('password_confirmation', model.value.password_confirmation)

      store.dispatch('register', formData)
        .then((res) => {
          router.push({ name : 'VerifyMobile'})
        })
        .catch((res) =>{
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

    function numbersOnly(evt) {
      evt = (evt) ? evt : window.event;
      var charCode = (evt.which) ? evt.which : evt.keyCode;
      if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
        evt.preventDefault();;
      } else {
        return true;
      }
    }

    function showModal(){
      isModalVisible.value = true
    }

    function confirm(){
    }

    function closeModal(){
      isModalVisible.value = false
    }

    return {
      model,
      loadStatus,
      register,
      numbersOnly,
      showModal,
      confirm,
      closeModal,
      isModalVisible,
      password,
      confirmPassword
    }
  }
}
</script>
<style>

</style>
