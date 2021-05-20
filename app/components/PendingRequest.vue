<template>
  <div>
    <ul>
      <li v-for="request in requests">
        {{ request.name }}
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  name: "PendingRequest",
  props: ['requests']
}
</script>

<style scoped>

</style>
