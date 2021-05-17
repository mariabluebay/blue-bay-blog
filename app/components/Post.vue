<template>
  <div class="card post-card">

    <div class="card-content">
      <div class="media">
        <div v-if="post.featured" class="media-left">
          <figure class="image is-200x200">
            <img :alt="post.title" :src="imageHost + post.featured" class="is-cover">
          </figure>
        </div>
        <div class="media-content">
          <p class="title is-4">{{ post.title }}</p>
          <div class="subtitle is-spaced is-6 is-flex is-flex-direction-row is-justify-content-space-between">
            <div>@{{ post.author.username }}</div>
            <div>
              <time :datetime="post.published_at">
                {{ post.published_at }}
              </time>
            </div>
          </div>
          <div class="content post-body">
            {{ post.excerpt }}
          </div>
        </div>
      </div>
    </div>

    <PostFooter :post="post"/>
  </div>
</template>

<script>
  import PostFooter from "./PostFooter";
  export default {
    components: {PostFooter},
    props: ['post']
  }
</script>
