<template>
  <article class="tile is-child block">
    <div class="p-4 has-background-dark has-text-white">
      <nuxt-link :to="'/posts/' + post.slug">
        <h3 class="title has-text-white">
          {{ post.title }}
        </h3>
      </nuxt-link>

      <div class="is-flex is-flex-direction-row is-justify-content-space-between">
        <div class="has-text-weight-bold">@{{ post.author.username }}</div>
        <div>
          <time :datetime="post.published_at">
            {{ post.published_at }}
          </time>
        </div>
      </div>
    </div>
    <figure v-if="post.featured" class="image is-4by3">
      <nuxt-link :to="'/posts/' + post.slug">
        <img :src="imageHost + post.featured"
             class="is-cover">
      </nuxt-link>
    </figure>
    <div class="content has-border main-post-body p-4" v-html="post.body"></div>
    <PostFooter :post="post" :author="post.author"/>
  </article>
</template>

<script>
  import PostFooter from "./PostFooter";
  export default {
    components: { PostFooter },
    props: ['post']
  }
</script>
