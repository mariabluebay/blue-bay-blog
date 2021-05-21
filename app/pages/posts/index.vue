<template>
  <div>
  <div class="tile is-ancestor">
    <div v-if="posts.length > 0" class="tile is-vertical is-8">
      <div class="tile">
        <div class="tile is-parent">
          <MainPost :post="posts[0]"/>
        </div>
      </div>
    </div>

    <div class="tile is-parent is-vertical is-4">
      <article v-for="(post, index) in posts"
               v-if="index > 0"
               :key="index"
               class="tile is-child block"
      >
        <Post :post="post" :author="post.author"/>
      </article>
    </div>
  </div>
    <Pagination :links="this.timeline.links" :meta="this.timeline.meta"/>
  </div>
</template>

<script>
  import Post from "../../components/Post";
  import MainPost from "../../components/MainPost";
  import Pagination from "../../components/Pagination";

  export default {
    components: { Pagination, MainPost, Post },

     async asyncData( {store, $axios} ) {
      let res = null;
      if (!store.state.auth.loggedIn) {
        res =  await $axios.$get('/posts')
      } else {
        res =  await $axios.$get(`/profiles/${store.state.auth.user.username}/timeline`)
      }
       return store.dispatch('timeline/updateTimeline', res);
    },

    computed: {
      posts() {
        return this.timeline.data
      }
    }
  }
</script>

