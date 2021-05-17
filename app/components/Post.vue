<template>
  <div class="card post-card">

    <div class="card-content">
      <div class="media">
        <div v-if="post.featured" class="media-left">
          <figure class="image is-200x200">
            <img :alt="post.title" :src="post.featured" class="is-cover">
          </figure>
        </div>
        <div class="media-content">
          <h4 class="small-post-title">{{ post.title }}</h4>
          <PostHeader :author="post.author" :time="post.published_at"/>
          <div class="content post-body">
            {{ post.excerpt }}
          </div>
        </div>
      </div>
    </div>

    <PostFooter :post="post" :author="author"/>
  </div>
</template>

<script>
  import PostFooter from "./PostFooter";
  import PostHeader from "./PostHeader";
  export default {
    components: {PostHeader, PostFooter },
    props: [
      'post',
      'author'
    ],
    methods: {
      async deletePost(id) {
        await this.$axios.delete(`/posts/${id}`)
          .then(() => this.$router.push('/posts'));
      }
    }
  }
</script>
