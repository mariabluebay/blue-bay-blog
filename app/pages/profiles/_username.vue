<template>
    <div>
      <div class="columns is-mobile is-centered">
        <div class="column is-half">

          <div class="card">

            <div class="card-image">
              <figure class="image is-2by1">
                <img :src="account.cover"
                     alt="Profile Cover"
                     class="is-cover">
              </figure>
            </div>

            <div class="file is-flex is-centered profile-card-avatar">
              <figure class="image is-200x200">
                <img
                  :src="account.avatar"
                  :alt="account.username"
                  class=" is-rounded rounded-full border-solid border-white border-2 w-12 h-12 object-cover"
                  id="profilePicture"/>
              </figure>
            </div>

            <div class="card-content">
              <FollowButton :account="account"/>

              <h3 class="title is-2 is-spaced bd-anchor-title has-text-centered">
                <span class="is-upper">
                 {{ account.name ? account.name : account.username }}
                </span>
              </h3>
              <h4 class="subtitle is-4 has-text-centered has-text-grey">
                {{ account.about ?  account.about : 'No tagline yet.'}}
              </h4>
            </div>

            <footer class="card-footer no-top-margin no-left-margin">
              <div class="card-footer-item has-text-centered is-flex-direction-column">
                <h5> {{ account.followers_count + account.follows_count }} </h5>
                <p>  Friends </p>
              </div>
              <div class="card-footer-item is-flex-direction-column">
                <h5> {{ account.posts_count }} </h5>
                <p> Posts </p>
              </div>
              <div class="card-footer-item is-flex-direction-column">
                <h5> {{ account.comments_count }} </h5>
                <p> Comments </p>
              </div>

            </footer>
            <br>

          </div>

        </div>
      </div>
    </div>
</template>
<script>
import FollowButton from "../../components/FollowButton";

export default {
  components: { FollowButton },

  middleware({ store, redirect, params }) {
    let blockedUsers = store.state.auth.user.blocked_users;
    if (blockedUsers.includes(params.username)) {
      return redirect(404)
    }
  },

  async asyncData({$axios, params}) {
    const {data} = await $axios.$get(`/profiles/${params.username}`);
    return {account : data}
  },

}
</script>
