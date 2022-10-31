<template>
  <div>
    <pre>{{ user }}</pre>
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
<style >

</style>
