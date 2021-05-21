<template>
    <div>
      <div class="tile is-ancestor">
        <div class="tile is-parent is-6">
          <ProfileCard :account="account">
            <FollowButton :account="account"/>
          </ProfileCard>
        </div>
        <div class="tile is-parent is-4 is-vertical">
          <h3 class="title is-4">Latest posts</h3>
          <article v-for="(post, index) in posts"
                   :key="index"
                   class="tile is-child block">
            <Post :post="post" :author="post.author"/>
          </article>
        </div>
      </div>
    </div>
</template>
<script>
import FollowButton from "../../components/FollowButton";
import ProfileCard from "../../components/ProfileCard";
import Post from "../../components/Post";

export default {
  components: { ProfileCard, FollowButton, Post },

  middleware({ store, redirect, params }) {
    if (store.state.authenticated) {
      let blockedUsers = store.state.auth.user.blocked_users;
      if (blockedUsers.length && blockedUsers.includes(params.username)) {
        return redirect(404)
      }
    }
  },

  async asyncData({ $axios, params }) {
    const {data} = await $axios.$get(`/profiles/${params.username}`);
    let posts = await $axios.$get(`/profiles/${params.username}/timeline`)
    return {account : data, posts: posts.data}
  },

}
</script>
