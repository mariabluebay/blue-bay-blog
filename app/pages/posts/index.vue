<template>
  <div class="tile is-ancestor">
    <div class="tile is-vertical is-8">
      <div class="tile">
        <div class="tile is-parent">
          <article class="tile is-child block">
            <figure class="image is-4by3" v-if="posts[0].featured">
              <img :src="imageHost + posts[0].featured"
                    class="is-cover">
            </figure>
          </article>
        </div>
      </div>
    </div>
      <div class="tile is-parent is-vertical is-4">
        <article v-for="(post, index) in posts"
                 :key="index"
                 v-if="index > 0"
                 class="tile is-child block">
          <div class="card">
            <div class="card-content">
              <div class="media">
                <div class="media-left" v-if="post.featured">
                  <figure class="image is-128x128">
                    <img :src="imageHost + post.featured" :alt="post.title">
                  </figure>
                </div>
                <div class="media-content">
                  <p class="title is-4">{{ post.title }}</p>
                  <p class="subtitle is-6">@{{ post.author.username }}</p>
                  <div class="content">
                    {{ post.excerpt }}
                    <br>
                    <time :datetime="post.published_at">{{ post.published_at }}</time>
                  </div>
                </div>
              </div>
           </div>

            <footer
              v-if="authenticated && (user.id === post.author.id  || user.role == 'admin' )"
              class="card-footer">
              <nuxt-link :to="'/posts/' + post.slug"
                         class="card-footer-item">
                Read
              </nuxt-link>
              <nuxt-link :to="'/posts/update/' + post.slug"
                         class="card-footer-item">
                Edit
              </nuxt-link>
              <a @click="deletePost(post.id)" class="card-footer-item">Delete</a>
            </footer>
            <footer v-else  class="card-footer">
              <nuxt-link :to="'/posts/' + post.slug" class="card-footer-item">
                Read
              </nuxt-link>
              <nuxt-link :to="'/posts/' + post.slug + '#comments'" class="card-footer-item">
                Comment
              </nuxt-link>
            </footer>
          </div>
        </article>
      </div>


  </div>
</template>

<script>

export default {
  data () {
    return {
      posts: []
    }
  },
  async asyncData ( { $axios }) {
    let { data } = await  $axios.$get( '/posts' )
    return {
      posts: data
    }
  },
  methods :{
   async deletePost (id) {
      await this.$axios.delete(`/posts/${ id }`)
     .then(() =>  this.$router.push('/posts'));
    }
  }
}
</script>
