<template>
  <footer
    v-if="authenticated && (user.username === author.username  || user.role === 'admin' )"
    class="card-footer custom-card-footer has-background-black">
    <nuxt-link :to="'/posts/' + post.slug"
               class="card-footer-item has-text-white has-text-weight-bold	">
      Read
    </nuxt-link>
    <nuxt-link :to="{ name: 'posts-edit', params: { slug: post.slug}}"
               class="card-footer-item has-text-white has-text-weight-bold">
      Edit
    </nuxt-link>
    <a class="card-footer-item has-text-white has-text-weight-bold" @click="deletePost(post.id)">Delete</a>
  </footer>
  <footer v-else class="card-footer has-background-black has-text-bold">
    <nuxt-link :to="'/posts/' + post.slug" class="card-footer-item has-text-white has-text-weight-bold">
      Read
    </nuxt-link>
    <nuxt-link :to="'/posts/' + post.slug + '#comments'" class="card-footer-item has-text-white has-text-weight-bold">
      Comment
    </nuxt-link>
  </footer>
</template>

<script>
  export default {
    name: "PostFooter",
    props: [
      'post',
      'author'
    ],
    methods: {
      async deletePost (id) {
        await this.$axios.delete(`/posts/${ id }`)
          .then(() => this.$nuxt.refresh());
      }
    }
  }
</script>
