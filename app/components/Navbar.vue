<template>
  <nav class="navbar" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
      <nuxt-link to="/" class="navbar-item">
        <LogoSmall />
      </nuxt-link>

      <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
      </a>
    </div>

    <div id="mainNavigation" class="navbar-menu">
      <div class="navbar-start">
        <nuxt-link to="/posts" class="navbar-item">
          Explore
        </nuxt-link>

        <template v-if="authenticated">
          <div class="navbar-item has-dropdown is-hoverable">
            <a class="navbar-link">
              More
            </a>
            <div class="navbar-dropdown">
              <nuxt-link to="/profiles"
                         class="navbar-item">
                View Profile
              </nuxt-link>
              <nuxt-link to="/profiles/edit"
                         class="navbar-item">
                Edit Profile
              </nuxt-link>
              <nuxt-link to="/posts/create" class="navbar-item">
                Create Post
              </nuxt-link>
              <nuxt-link to="/posts/friends/request" class="navbar-item">
                Friend Requests
              </nuxt-link>
            </div>
          </div>
        </template>

      </div>

      <div class="navbar-end">
        <div class="navbar-item">
          <div class="buttons">

            <template v-if="authenticated">
              <a @click.prevent="logout" class="button is-light">
                Logout
              </a>
            </template>

            <template v-if="!authenticated">
              <nuxt-link to="/register" class="button is-primary">
                Sign Up
              </nuxt-link>
              <nuxt-link to="/login" class="button is-light">
                Log In
              </nuxt-link>
            </template>

          </div>
        </div>
      </div>
    </div>
  </nav>

</template>

<script>
import LogoSmall from "./LogoSmall";
export default {
  components: {LogoSmall},
  methods: {
    logout () {
      this.$auth.logout()
        .then(()=>this.$router.push('/'))
    }
  }
}
</script>
