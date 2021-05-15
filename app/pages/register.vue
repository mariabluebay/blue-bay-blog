<template>

  <div class="columns is-mobile is-centered">
    <div class="column is-one-quarter has-background-light p-6 box">
      <form @submit.prevent="register" autocomplete="off">
        <h3 class="title is-4 is-spaced bd-anchor-title has-text-centered	">
          <span>
           Hello!
          </span>
        </h3>
        <div class="field">
          <p class="control has-icons-left has-icons-right">
            <input :class="{'is-danger':errors.username , 'is-success': true}"
                   v-model.trim="form.username"
                   type="text"
                   name="username"
                   class="input"
                   placeholder="Username"
                   required
                   autofocus>
            <span class="icon is-small is-left">
              <font-awesome-icon :icon="['fas', 'user']"/>
            </span>
            <span class="icon is-small is-right" v-if="errors.username">
              <font-awesome-icon :icon="['fas', 'exclamation-triangle']"/>
            </span>
          </p>
          <p class="help is-danger" v-if="errors.username">{{ errors.username[0]}}</p>
        </div>
        <div class="field">
          <p class="control has-icons-left has-icons-right">
            <input :class="{'is-danger':errors.email , 'is-success': true}"
                   v-model.trim="form.email"
                   type="email"
                   name="email"
                   class="input"
                   placeholder="Email"
                   required>
            <span class="icon is-small is-left">
              <font-awesome-icon :icon="['fas', 'envelope']"/>
            </span>
            <span class="icon is-small is-right" v-if="errors.email">
              <font-awesome-icon :icon="['fas', 'exclamation-triangle']"/>
            </span>
          </p>
          <p class="help is-danger" v-if="errors.email">{{ errors.email[0]}}</p>
        </div>

        <div class="field">
          <p class="control has-icons-left has-icons-right">
            <input :class="{'is-danger':errors.password , 'is-success': true}"
                   v-model.trim="form.password"
                   type="password"
                   name="password"
                   class="input"
                   placeholder="Password"
                   required>
            <span class="icon is-small is-left">
              <font-awesome-icon :icon="['fas', 'lock']"/>
            </span>
            <span class="icon is-small is-right" v-if="errors.password">
              <font-awesome-icon :icon="['fas', 'exclamation-triangle']"/>
            </span>
          </p>
          <p class="help is-danger" v-if="errors.password">{{ errors.password[0]}}</p>
        </div>

        <div class="field">
          <p class="control">
            <button class="button is-primary is-fullwidth"  type="submit">
              Sign Up
            </button>
          </p>
        </div>
      </form>
      <p class="mt-2 has-text-centered">Already have an account? <nuxt-link to="/login">Login</nuxt-link></p>
    </div>
  </div>

</template>

<script>

export default {

  data () {
    return {
      form: {
        username: '',
        name: '',
        email: '',
        password: ''
      }
    }
  },

  methods: {
    async register () {
      await this.$axios.$post('register', this.form)
        .then ( () => {
          //returns the profile or the intended page
          path: this.$route.query.redirect || '/profile'
        })
        .catch ( err => console.log( err ) )
    }
  }
}
</script>
