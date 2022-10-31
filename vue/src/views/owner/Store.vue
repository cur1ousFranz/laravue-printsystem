<template>
  <div class="mx-auto max-w-7xl sm:px-6 lg:px-4">

    <div class="px-4 py-4 sm:px-0">
      <div class="h-96 rounded-lg border-4 border-dashed border-gray-200">
      </div>
    </div>
  </div>
</template>
<script>
import store from '../../store'
export default {
  setup() {

    const user = store.state.user

    return { user }
  }
}
</script>
<style>

</style>
