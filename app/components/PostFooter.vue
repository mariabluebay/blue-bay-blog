<template>
  <footer
    v-if="authenticated && (user.id === post.author.id  || user.role === 'admin' )"
    class="card-footer has-background-black">
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
    props: ['post']
  }
</script>
