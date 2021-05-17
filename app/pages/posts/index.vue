<template>
  <div class="tile is-ancestor">
    <div class="tile is-vertical is-8">
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
               class="tile is-child block">
        <Post :post="post" :author="post.author"/>
      </article>
    </div>
  </div>
</template>

<script>
  import Post from "../../components/Post";
  import MainPost from "../../components/MainPost";

  export default {
    components: { MainPost, Post },

    data() {
      return {
        posts: []
      }
    },
    async asyncData({$axios}) {
      let {data} = await $axios.$get('/posts')
      return {
        posts: data
      }
    },
    methods: {
      async deletePost(id) {
        await this.$axios.delete(`/posts/${id}`)
          .then(() => this.$router.push('/posts'));
      }
    }
  }
</script>

