<template>

  <div class="mx-auto max-w-7xl sm:px-6 lg:px-4 flex">
      <div class="w-8/12 bg-slate-200">
      </div>
      <div class="w-4/12 px-3 py-4 space-y-4 rounded-md shadow-md bg-gray-100">
        <h1 class="text-2xl font-bold text-gray-800">Choose</h1>
        <div class="flex space-x-3">
          <div class="form-check">
            <input class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="flexRadioDefault" id="flexRadioDefault1" checked>
            <label class="form-check-label inline-block text-gray-800" for="flexRadioDefault1">
              Print Document
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="flexRadioDefault" id="flexRadioDefault2" disabled>
            <label class="form-check-label line-through inline-block cursor-not-allowed text-gray-800" for="flexRadioDefault2">
              Print Tarpaulin
            </label>
          </div>
        </div>
        <form @submit.prevent="submit" class="py-6 space-y-3" enctype="multipart/form-data">
          <div class="flex align-items-center">
            <label for="file" class="cursor-pointer flex">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 py-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
              </svg>
            </label>
            <input @change="onFileChoose" type="file" id="file" class="py-2 border rounded-md" style="display: none">
            <h1 class="py-2 underline">{{ model.pdfName }}</h1>
          </div>

          <h1 class="text-gray-800">Number of Pages:
            <span class="font-bold text-base" style="letter-spacing: 1px">
              {{ model.pageCount }}
            </span>
          </h1>
          <div class="mb-3 flex">
            <div class="w-full">
              <label for="select-size">Select Size</label>
              <select @change="select" v-model="model.size" class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm block w-full p-2.5 focus:border-current focus:ring-0" id="select-size">
                  <option value="a4">A4</option>
                  <option value="long">Long</option>
                  <option value="short">Short</option>
              </select>
            </div>
          </div>

          <div class="mb-3 flex">
            <div class="w-full">
              <label for="select-size">Select Color</label>
              <select @change="select" v-model="model.color" class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm block w-full p-2.5 focus:border-current focus:ring-0" id="select-size">
                  <option value="bnw">Black and White</option>
                  <option value="colored">Colored</option>
              </select>
            </div>
          </div>

          <div class="py-6 flex justify-between">
            <div class="mt-4">
              <h1 class="px-2 text-2xl">Total: ₱ {{ model.total }}.00</h1>
            </div>
            <!-- TODO PAYMENT GATEWAY -->
            <button type="submit" class="mt-3 rounded-full cursor-pointer">
              <img src="https://getpaid.gcash.com/assets/img/paynow.png">
            </button>
          </div>
        </form>
      </div>
  </div>
</template>
<script>
import store from '../../store'
import { useRoute } from "vue-router";
import { ref } from '@vue/reactivity';
import * as pdfjsLib from 'pdfjs-dist';
import { watch } from '@vue/runtime-dom';
import { alert } from '../../alert.js'
const pdfjs = await import('pdfjs-dist/build/pdf');
const pdfjsWorker = await import('pdfjs-dist/build/pdf.worker.entry');
pdfjs.GlobalWorkerOptions.workerSrc = pdfjsWorker;
export default {
  setup(){

  const route = useRoute()

  const shop = ref({
    status : null,
    application : {},
    services : []
  })

  const model = ref({
    file : null,
    pdfName : 'Upload File',
    pageCount : null,
    size : 'a4',
    color : 'bnw',
    total : 0,
    prices : null,
  })

  if(route.params.id){
    store.dispatch('getCustomerShopDetails', route.params.id)
      .then((res) => {
        if(shop.value.services.length){
          if(inArray(shop.value.services, 'documents')){
            const service = getService(shop.value.services, 'documents')
            if(service[0].service_price.price){
              service[0].service_price.price = JSON.parse(service[0].service_price.price)
              model.value.prices = service[0].service_price.price
            }
          }
        }
      return res
    })
  }

  function select(){
    if(model.value.size === 'a4'){
      if(model.value.color === 'bnw'){
        model.value.total = model.value.prices.a4_bnw * model.value.pageCount
      }
      if(model.value.color === 'colored'){
        model.value.total = model.value.prices.a4_colored * model.value.pageCount
      }
    }

    if(model.value.size === 'long'){
      if(model.value.color === 'bnw'){
        model.value.total = model.value.prices.long_bnw * model.value.pageCount
      }
      if(model.value.color === 'colored'){
        model.value.total = model.value.prices.long_colored * model.value.pageCount
      }
    }

    if(model.value.size === 'short'){
      if(model.value.color === 'bnw'){
        model.value.total = model.value.prices.short_bnw * model.value.pageCount
      }
      if(model.value.color === 'colored'){
        model.value.total = model.value.prices.short_colored * model.value.pageCount
      }
    }
  }

  // Get Service according to passed service_name
  function getService(array, string){
    return array.filter((service) => service.service_name === string)
  }

  // Check if the service name is in array of objects
  function inArray(array, name){
    const checkServiceName = obj => obj.service_name === name;
    return array.some(checkServiceName)
  }

  watch(
    () => store.state.customerShopDetails.data,
    (newVal, oldVal) => {
      shop.value = {
        ...JSON.parse(JSON.stringify(newVal)),
      };
      }
  );

  function onFileChoose(ev){

      const file = ev.target.files[0];
      model.value.file = file
      model.value.pdfName = file.name

      // Count number of pages in pdf
      const reader = new FileReader()
      reader.onload = () => {
        const typedArray = new Uint8Array(reader.result)
        const task = pdfjsLib.getDocument(typedArray)
        task.promise.then((pdf) => {
          model.value.pageCount = pdf.numPages
          select()
        })
      }

      reader.readAsArrayBuffer(file)
  }

  function submit(){
    const service = getService(shop.value.services, 'documents')
    const formData = new FormData()
    formData.append('file', model.value.file)
    formData.append('shop_id', shop.value.id)
    formData.append('service_id', service[0].id)
    formData.append('size', model.value.size)
    formData.append('color', model.value.color)
    formData.append('pages', model.value.pageCount)

    store.dispatch('customerUploadFile', formData)
      .then((url) => {
        /** THis is for gcash redirect */
        // window.open(url.data)


         alert('Queue submitted!')
      })

  }

    return {
      model,
      shop,
      onFileChoose,
      select,
      submit
    }
  }
}
</script>
<style>

</style>
