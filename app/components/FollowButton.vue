<template v-if="authenticated">
  <div v-if="user.username !== account.username" class="buttons">

    <button v-if="account.friendship_status == 'pending' && !account.is_followed"
            @click.prevent="accept(account.username)"
            class="button is-primary is-small"
    >
      <span class="icon is-small">
        <font-awesome-icon :icon="['fas', 'user-check']" />
      </span>
      <span>Accept</span>
    </button>

    <button v-if="account.friendship_status == 'pending' && !account.is_followed"
            @click.prevent="decline(account.username)"
            class="button is-danger is-small"
    >
      <span class="icon is-small">
        <font-awesome-icon :icon="['fas', 'user-check']" />
      </span>
      <span>Decline</span>
    </button>

    <button v-if="account.friendship_status == 'pending' && account.is_followed"
            @click.prevent="follow(account.username)"
            class="button is-danger is-small"
    >
      <span class="icon is-small">
        <font-awesome-icon :icon="['fas', 'user-minus']" />
      </span>
      <span>Cancel</span>
    </button>


    <button v-if="account.friendship_status == 'confirmed'"
            @click.prevent="decline(account.username)"
            class="button is-danger is-small"
    >
      <span class="icon is-small">
        <font-awesome-icon :icon="['fas', 'user-minus']" />
      </span>
      <span>Unfriend</span>
    </button>


    <button v-if="account.friendship_status == null"
            @click.prevent="follow(account.username)"
            class="button is-primary is-small"
    >
      <span class="icon is-small">
        <font-awesome-icon :icon="['fas', 'user-plus']" />
      </span>
      <span>Add Friend</span>
    </button>

    <button @click.prevent="block(account.username)"
            class="button is-danger is-outlined is-small"
    >
      <span class="icon is-small">
        <font-awesome-icon :icon="['fas', 'user-slash']" />
      </span>
      <span>Block</span>
    </button>

  </div>
</template>

<script>
import { mapActions } from "vuex";

export default {
  name: "FollowButton",
  props: [
    'account'
  ],
  methods: {
    ...mapActions( ["updateFriends"] ),

     follow(username) {
        this.$axios.post(`/profiles/${username}/follow`)
        .then(() => {
          this.updateFriends();
          this.$nuxt.refresh();
        });
    },

    block(username) {
        this.$axios.post(`/profiles/${username}/block`)
        .then(() => {
          this.updateFriends();
          this.$router.push({ path: '/profiles' });
        });
    },

    accept(username) {
        this.$axios.post(`/profiles/${username}/accept`)
        .then(() => {
          this.updateFriends();
          this.$nuxt.refresh()
        });
    },

    decline (username) {
        this.$axios.post(`/profiles/${username}/decline`)
        .then(() => {
          this.updateFriends();
          this.$nuxt.refresh();
        });
    }
  }
}
</script>

<style scoped>

</style>
