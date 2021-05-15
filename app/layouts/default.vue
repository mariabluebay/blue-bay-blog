<template>
  <div>
    <Navbar />
    <div class="p-5">
      <Nuxt/>
    </div>


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
