<template>
  <div class="px-6">
    <Navbar />
    <hr class="has-background-black">
    <Nuxt/>
  </div>
</template>

<script>
  import Navbar from "@/components/Navbar"

  export default {
    components: {
      Navbar
    }
  }

</script>
