<template>
  <div>
    <h2 class="title is-4 is-spaced bd-anchor-title has-text-centered	">
          <span>
           Latest posts
          </span>
    </h2>

    <div class="columns is-multiline is-mobile is-vcentered p-3">
      <div v-for="(post, index) in posts" :key="index"
           class="column is-one-third has-text-centered box m-2">
        <div class="card-image" v-if="post.featured">
          <figure class="image is-4by3">
            <img :src="imageHost+post.featured" :alt="post.title" class="is-cover">
          </figure>
        </div>
        <div class="card-content">
          <div class="media">
            <div class="media-left">
              <figure class="image is-48x48" v-if="post.author.avatar">
                <img :src="imageHost+post.author.avatar" :alt="post.author.name" class="is-cover">
              </figure>
              <figure class="image is-48x48" v-else>
                <img :src="imageHost+'/images/avatar.svg'" :alt="post.author.name" class="is-cover">
              </figure>
            </div>
            <div class="media-content">
              <p class="title is-4">{{post.author.name}}</p>
              <p class="subtitle is-6">@{{ post.author.username }}</p>
            </div>
          </div>

          <div class="content">
            {{ post.excerpt }} <a>@{{ post.author.username }}</a>.
            <br>
            <time datetime="2016-1-1">{{ post.published_at}}</time>
          </div>
        </div>
      </div>
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
    console.log(data);
    return {
      posts: data
    }
  }
}
</script>
