<template>

  <div class="mx-auto max-w-7xl sm:px-6 lg:px-4">
      <div class="w-6/12 mx-auto px-3 py-4 space-y-4 rounded-md shadow-md bg-gray-100">
        <!-- <form @submit.prevent="submit" enctype="multipart/form-data">
          <input @change="onFileChoose" type="file">
          <button class="bg-green-500 px-2 py-3 text-white rounded-md" type="submit">Submit PDF</button>
        </form> -->
        <h1 class="text-2xl font-bold text-gray-800">Choose</h1>
        <div class="flex space-x-3">
          <div class="form-check">
            <input class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
            <label class="form-check-label inline-block text-gray-800" for="flexRadioDefault1">
              Print Document
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
            <label class="form-check-label inline-block text-gray-800" for="flexRadioDefault2">
              Print Tarpaulin
            </label>
          </div>
        </div>
        <form class="py-6 space-y-3">
          <div class="flex align-items-center">
            <label for="file" class="cursor-pointer">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 px-2 py-2 border-2 rounded-md border-gray-700">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
              </svg>
            </label>
            <input @change="onFileChoose" type="file" id="file" class="py-2 border rounded-md" style="display: none">
            <h1 class="py-2 px-2 underline">{{ model.pdfName }}</h1>
          </div>

          <h1 class="text-gray-800">Number of Pages: <span class="font-bold text-base" style="letter-spacing: 1px">{{ model.pageCount }}</span></h1>
          <div class="mb-3 flex">
            <div class="w-6/12">
              <label for="select-size">Select Size</label>
              <select class="mt-1 form-select appearance-none block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat border border-solid border-gray-300 rounded transition ase-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" id="select-size">
                  <option value="1">A4</option>
                  <option value="2">Long</option>
                  <option value="3">Short</option>
              </select>
            </div>
          </div>

          <div class="mb-3 flex">
            <div class="w-6/12">
              <label for="select-size">Select Color</label>
              <select class="mt-1 form-select appearance-none block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat border border-solid border-gray-300 rounded transition ase-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" id="select-size">
                  <option value="1">Black and White</option>
                  <option value="2">Colored</option>
              </select>
            </div>
          </div>

        </form>
      </div>
  </div>
</template>
<script>
import store from '../../store'
import { useRoute } from "vue-router";
import { ref } from '@vue/reactivity';
export default {
  setup(){

    const route = useRoute()

    const model = ref({
      pdf : null,
      pageCount : null,
      pdfName : null
    })

    if(route.params.id){
      store.dispatch('getCustomerShopDetails', route.params.id)
    }

    function onFileChoose(ev){

      const file = ev.target.files[0];
      model.value.pdfName = file.name

      const reader = new FileReader()
        reader.onload = () => {
          const typedArray = new Uint8Array(reader.result)
          const task = pdfjsLib.getDocument(typedArray)
          task.promise.then((pdf) => {
            model.value.pageCount = pdf.numPages

          })

          // display in frontend
          model.value.pdf = reader.result
        }
      reader.readAsArrayBuffer(file)

    }

    function submit(){
      console.log(model.value);
      store.dispatch('customerUploadFile', model.value)
        .then(function (res) {
            console.log(res);
        })
    }

      return { model, onFileChoose, submit }
    }
}
</script>
<style>

</style>
