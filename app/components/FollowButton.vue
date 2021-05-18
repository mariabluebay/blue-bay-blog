<template v-if="authenticated">
  <div v-if="user.username !== account.username">
    <a @click.prevent="follow(account.username)" class="button is-light">
      {{ account.is_followed ? 'Unfriend' : 'Add Friend' }}
    </a>
  </div>
</template>

<script>
export default {
  name: "FollowButton",
  props: [
    'account'
  ],
  methods: {
    async follow(username) {
      await this.$axios.post(`/profiles/${username}/follow`)
        .then(() => this.$nuxt.refresh());
    }
  }
}
</script>

<style scoped>

</style>
