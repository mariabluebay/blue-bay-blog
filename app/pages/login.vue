<template>
  <div class="columns is-mobile is-centered">
    <div class="column is-one-quarter has-background-light p-6 box">
      <form @submit.prevent="login" autocomplete="off">
        <h3 class="title is-4 is-spaced bd-anchor-title has-text-centered	">
          <span>
           Welcome back!
          </span>
        </h3>
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
              Login
            </button>
          </p>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      form: {
        email: '',
        password: ''
      }
    }
  },

  methods: {
    async login () {
      await this.$auth.loginWith('local', {data: this.form})
        .then( () => {
          this.$router.push({
            path: this.$route.query.redirect || '/profiles'
          })
        })
        .catch ( err => console.log(err) )
    }
  }

}
</script>

