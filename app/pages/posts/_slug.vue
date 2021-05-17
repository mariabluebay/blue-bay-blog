<template>
  <div class="columns is-mobile is-centered mt-6">
    <div class="column is-half">
      <div class="card">
        <header
          v-if="authenticated && (user.id === post.author.id  || user.role === 'admin' )"
          class="card-header">
          <nuxt-link :to="{ name: 'posts-edit', params: { slug: post.slug}}"
                     class="card-footer-item">
            Edit
          </nuxt-link>
          <a @click="deletePost(post.id)" class="card-footer-item">Delete</a>
        </header>
        <div class="card-image">
          <figure v-if="post.featured"
                  class="image is-4by3">
            <img :src="post.featured"
                 alt="post.title"
                 class="is-cover">
          </figure>
        </div>
        <div class="card-content">
          <div class="media">
            <div v-if="post.author.avatar"
                 class="media-left">
              <figure class="image is-48x48">
                <img :src="post.author.avatar"
                     :alt="post.author.username"
                      class="is-cover">
              </figure>
            </div>
            <div class="media-content">
              <p class="title is-4">@{{ post.author.username }}</p>
              <p class="subtitle is-6">{{ post.published_at }}</p>
            </div>
          </div>
          <h2 class="post-title">{{ post.title }}</h2>
          <div v-html="post.body"
               class="content main-post-body">
          </div>
        </div>
        <footer  class="card-footer">
          <div id="comments" class="p-3">
            <h1>Comments</h1>
          </div>
        </footer>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  async asyncData ({ $content, $axios, params }) {
    const { data } = await $axios.$get(`/posts/${ params.slug }`);
    return { post: data }
  },
  methods :{
    async deletePost (id) {
      await this.$axios.delete(`/posts/${ id }`)
        .then(() =>  this.$router.push('/posts'));
    }
  }
}
</script>
