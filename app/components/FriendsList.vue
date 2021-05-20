<template>
  <div class="max-width full mb-4">
    <slot></slot>
    <div v-if="friends !== undefined && friends.length === 0">Nothing to display.</div>
    <div v-for="(friend) in friends"
         class="media"
    >
      <div class="media-left">
        <a :href="'/profiles/'+ friend.username">
          <figure class="image is-24x24">
            <img :src="friend.avatar" :alt="friend.username">
          </figure>
        </a>
      </div>
      <div class="media-content">
        <p class="subtitle is-6" >
          <a :href="'/profiles/'+ friend.username">
            {{ friend.name ? friend.name : friend.username }}
          </a>
        </p>
        <p class="buttons">

          <template v-if="list === 'pending'">
            <button @click.prevent="accept(friend.username)"
                    class="button is-primary is-small">
            <span class="icon is-small">
              <font-awesome-icon :icon="['fas', 'user-check']" />
            </span>
              <span>Accept</span>
            </button>
            <button @click.prevent="decline(friend.username)"
                    class="button is-danger is-small">
            <span class="icon is-small">
              <font-awesome-icon :icon="['fas', 'user-minus']" />
            </span>
              <span>Decline</span>
            </button>
          </template>

          <template v-else-if="list === 'confirmed'">
            <button @click.prevent="decline(friend.username)"
                    class="button is-danger is-small">
            <span class="icon is-small">
              <font-awesome-icon :icon="['fas', 'user-minus']" />
            </span>
              <span>Unfriend</span>
            </button>
            <button @click.prevent="block(friend.username)"
                    class="button is-danger is-outlined is-small">
            <span class="icon is-small">
              <font-awesome-icon :icon="['fas', 'user-minus']" />
            </span>
              <span>Block</span>
            </button>
          </template>

          <template v-else-if="list === 'sent'">
            <button @click.prevent="decline(friend.username)"
                    class="button is-danger is-small">
            <span class="icon is-small">
              <font-awesome-icon :icon="['fas', 'user-minus']" />
            </span>
              <span>Cancel</span>
            </button>
            <button @click.prevent="block(friend.username)"
                    class="button is-danger is-outlined is-small">
            <span class="icon is-small">
              <font-awesome-icon :icon="['fas', 'user-minus']" />
            </span>
              <span>Block</span>
            </button>
          </template>
        </p>

      </div>
    </div>

  </div>
</template>

<script>
import {mapActions} from 'vuex'

export default {
  name: "FriendsList",
  props: [
    'friends',
    'list'
  ],
  methods: {
    ...mapActions( ["updateFriends"] ),

     accept(username) {
       this.$axios.post(`/profiles/${username}/accept`)
       .then( () => this.updateFriends())
    },

     decline (username) {
      this.$axios.post(`/profiles/${username}/decline`)
      .then( () => this.updateFriends() )
    },

    block(username) {
      this.$axios.post(`/profiles/${username}/block`)
        .then(() => this.updateFriends() )
    },
  }
}
</script>

<style scoped>

</style>
