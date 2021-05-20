<template>
  <img src="~/assets/images/logo-small.png" alt="Blog" class="logo">
</template>
<script>
export default {
  name: "LogoSmall"
}
</script>
<style>
.logo {
  animation: 1s appear;
  margin: auto;
}

@keyframes appear {
  0% {
    opacity: 0;
  }
}
</style>
