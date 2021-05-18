<template>
  <div>
    <div class="columns is-mobile is-centered">
      <div class="column is-half">

        <div class="card">

          <div class="card-image">
            <figure class="image is-2by1">
              <img :src="user.cover"
                   alt="Profile Cover"
                   class="is-cover">
            </figure>
          </div>

          <div class="file is-flex is-centered profile-card-avatar">
            <figure class="image is-200x200">
              <img
                :src="user.avatar"
                :alt="user.username"
                class=" is-rounded rounded-full border-solid border-white border-2 w-12 h-12 object-cover"
                id="profilePicture"/>
            </figure>
          </div>

          <div class="card-content">

            <h3 class="title is-2 is-spaced bd-anchor-title has-text-centered">
                <span class="is-upper">
                 {{ user.name ? user.name : user.username }}
                </span>
            </h3>
            <h4 class="subtitle is-4 has-text-centered has-text-grey">
              {{ user.about ?  user.about : 'No tagline yet.'}}
            </h4>
          </div>

          <footer class="card-footer no-top-margin no-left-margin">
            <div class="card-footer-item has-text-centered is-flex-direction-column">
              <h5> {{ user.followers_count + user.follows_count }} </h5>
              <p>  Friends </p>
            </div>
            <div class="card-footer-item is-flex-direction-column">
              <h5> {{ user.posts_count }} </h5>
              <p> Posts </p>
            </div>
            <div class="card-footer-item is-flex-direction-column">
              <h5> {{ user.comments_count }} </h5>
              <p> Comments </p>
            </div>

          </footer>
          <br>

        </div>

      </div>
    </div>
  </div>

</template>
<script>
import PendingRequest from "../../components/PendingRequest";

export default {
  components: { PendingRequest },
  middleware: ['auth'],
}
</script>
