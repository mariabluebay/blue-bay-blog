<template>
  <div>
    <div class="tile is-ancestor">
      <div class="tile is-parent is-2 is-vertical">
        <FriendsList :friends="user.pending_friend_request" list='pending'>
          <h3 class="title is-4">Pending friend requests</h3>
        </FriendsList>
        <FriendsList :friends="user.friends" list='confirmed'>
          <h3 class="title is-4">Friends</h3>
        </FriendsList>
        <FriendsList :friends="user.follows" list='sent'>
          <h3 class="title is-4">Sent</h3>
        </FriendsList>
      </div>
      <div class="tile is-child is-6">
        <ProfileCard :account="user"/>
      </div>
      <div class="tile is-parent is-4 is-vertical">
        <h3 class="title is-4">Latest posts</h3>
        <article v-for="(post, index) in posts"
                 :key="index"
                 class="tile is-child block"
        >
          <Post :post="post" :author="post.author"/>
        </article>
        <Pagination :links="this.timeline.links" :meta="this.timeline.meta"/>
      </div>
    </div>
  </div>
</template>
<script>
import PendingRequest from "../../components/PendingRequest";
import ProfileCard from "../../components/ProfileCard";
import FriendsList from "../../components/FriendsList";
import Post from "../../components/Post";

export default {
  components: {
    FriendsList,
    ProfileCard,
    PendingRequest,
    Post
  },
  middleware: ['auth'],

  async asyncData( {store, $axios} ) {
    let res = await $axios.$get(`/profiles/${store.state.auth.user.username}/timeline`)
    return store.dispatch('timeline/updateTimeline', res);
  },
  computed: {
    posts() {
      return this.timeline.data
    }
  }
}
</script>
