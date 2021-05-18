<template>
  <article class="tile is-child block">
    <div class="p-4 has-background-dark has-text-white">
      <nuxt-link :to="'/posts/' + post.slug">
        <h3 class="title has-text-white">
          {{ post.title }}
        </h3>
      </nuxt-link>
      <PostHeader :author="post.author" :time="post.published_at"/>
    </div>
    <figure v-if="post.featured" class="image is-4by3">
      <nuxt-link :to="'/posts/' + post.slug">
        <img :src="post.featured"
             class="is-cover">
      </nuxt-link>
    </figure>
    <div class="content has-border main-post-body p-4" v-html="post.body"></div>
    <PostFooter :author="post.author" :post="post"/>
  </article>
</template>

<script>
  import PostFooter from "./PostFooter";
  import PostHeader from "./PostHeader";

  export default {
    name: "MainPost",
    components: {
      PostHeader,
      PostFooter
    },
    props: [
      'post'
    ],
    methods: {
      async deletePost(id) {
        await this.$axios.delete(`/posts/${id}`)
          .then(() => this.$router.push('/posts'));
      }
    }
  }
</script>
