<template v-if="authenticated">
  <div v-if="user.username !== account.username" class="buttons">
    <button v-if="account.is_followed"
            @click.prevent="follow(account.username)"
            class="button is-danger is-small">
      <span class="icon is-small">
        <font-awesome-icon :icon="['fas', 'user-minus']" />
      </span>
      <span>Unfriend</span>
    </button>

    <button v-else
            @click.prevent="follow(account.username)"
            class="button is-primary is-small">
      <span class="icon is-small">
        <font-awesome-icon :icon="['fas', 'user-plus']" />
      </span>
      <span>Add Friend</span>
    </button>

    <button @click.prevent="block(account.username)"
            class="button is-danger is-outlined is-small">
      <span class="icon is-small">
        <font-awesome-icon :icon="['fas', 'user-slash']" />
      </span>
      <span>Block</span>
    </button>

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
    },

    block(username) {
      this.$axios.post(`/profiles/${username}/block`)
        .then(() => {
          this.$router.push({ path: '/profiles' });
        });
    }
  }
}
</script>

<style scoped>

</style>
