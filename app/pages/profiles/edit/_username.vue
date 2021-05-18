<template>
  <div class="hero is-fullheight is-primary has-background">
    <img :src="coverSrc"
         alt="Profile Cover"
         class="hero-background is-transparent is-cover"/>
    <div class="hero-body">
      <div class="container">
        <h1 class="title has-text-centered">
          Edit Profile
        </h1>
        <div class="columns is-mobile is-centered">
          <div class="column is-half p-6 box">
            <form autocomplete="off" @submit.prevent="edit">

              <h3 class="title is-4 is-spaced bd-anchor-title has-text-centered	">
                <span>
                  Edit Profile
                </span>
              </h3>

              <div class="field ">
                <div class="file has-name is-fullwidth">
                  <label class="file-label">
                    <input
                      ref="cover"
                      :class="{'is-danger':errors.cover , 'is-primary': true}"
                      class="file-input"
                      name="cover"
                      type="file"
                      @change="previewCover">
                    <span class="file-cta">
                        <span class="file-icon">
                          <font-awesome-icon :icon="['fas', 'upload']"/>
                        </span>
                        <span class="file-label">
                          Cover image
                        </span>
                    </span>
                    <span class="file-name">
                      {{ coverPicName }}
                    </span>
                  </label>
                  <p v-if="errors.cover" class="help is-danger">{{ errors.cover[0] }}</p>
                </div>
              </div>

              <div class="field">
                <p class="control has-icons-left has-icons-right">
                  <input v-model="account.name"
                         :class="{'is-danger':errors.name , 'is-primary': true}"
                         autofocus
                         class="input"
                         name="name"
                         placeholder="Name"
                         required
                         type="text">
                  <span class="icon is-small is-left">
                    <font-awesome-icon :icon="['fas', 'user']"/>
                  </span>
                  <span v-if="errors.name" class="icon is-small is-right">
                    <font-awesome-icon :icon="['fas', 'exclamation-triangle']"/>
                  </span>
                </p>
                <p v-if="errors.name" class="help is-danger">{{ errors.name[0] }}</p>
              </div>

              <div class="field">
                <p class="control has-icons-left has-icons-right">
                  <textarea v-model="account.about"
                         :class="{'is-danger':errors.about , 'is-primary': true}"
                         autofocus
                         class="input"
                         name="about"
                         placeholder="About"
                         required
                         type="text"/>
                </p>
                <p v-if="errors.about" class="help is-danger">{{ errors.about[0] }}</p>
              </div>

              <div class="field">
                <p class="control has-icons-left has-icons-right">
                  <input v-model.trim="account.username"
                         :class="{'is-danger':errors.username , 'is-primary': true}"
                         autofocus
                         class="input"
                         name="username"
                         placeholder="Username"
                         required
                         type="text">
                  <span class="icon is-small is-left">
                      <font-awesome-icon :icon="['fas', 'user']"/>
                  </span>
                  <span v-if="errors.username" class="icon is-small is-right">
                    <font-awesome-icon :icon="['fas', 'exclamation-triangle']"/>
                  </span>
                </p>
                <p v-if="errors.username" class="help is-danger">{{ errors.username[0] }}</p>
              </div>

              <div class="field">
                <div class="file is-flex is-centered">
                  <figure class="image is-200x200 mb-2">
                  <img
                    :src="avatarSrc"
                    alt="Your profile picture"
                    class="rounded-full border-solid border-white border-2 w-12 h-12 object-cover"
                    id="profilePicture"/>
                  </figure>
                </div>
                <div class="file has-name is-fullwidth">
                  <label class="file-label">
                    <input
                      ref="avatar"
                      :class="{'is-danger':errors.avatar , 'is-primary': true}"
                      class="file-input"
                      name="avatar"
                      type="file"
                      @change="previewAvatar">
                    <span class="file-cta">
                        <span class="file-icon">
                          <font-awesome-icon :icon="['fas', 'upload']"/>
                        </span>
                        <span class="file-label">
                          Featured image
                        </span>
                    </span>
                    <span class="file-name">
                      {{ avatarPicName }}
                    </span>
                  </label>
                  <p v-if="errors.avatar" class="help is-danger">{{ errors.avatar[0] }}</p>
                </div>
              </div>

              <div class="field">
                <p class="control has-icons-left has-icons-right">
                  <input v-model.trim="account.email"
                         :class="{'is-danger':errors.email , 'is-primary': true}"
                         class="input"
                         name="email"
                         placeholder="Email"
                         required
                         type="email">
                  <span class="icon is-small is-left">
                <font-awesome-icon :icon="['fas', 'envelope']"/>
                  </span>
                        <span v-if="errors.email" class="icon is-small is-right">
                    <font-awesome-icon :icon="['fas', 'exclamation-triangle']"/>
                  </span>
                </p>
                <p v-if="errors.email" class="help is-danger">{{ errors.email[0] }}</p>
              </div>

              <div class="field">
                <p class="control has-icons-left has-icons-right">
                  <input v-model.trim="account.password"
                         :class="{'is-danger':errors.password , 'is-primary': true}"
                         class="input"
                         name="password"
                         placeholder="Password"
                         required
                         type="password">
                  <span class="icon is-small is-left">
              <font-awesome-icon :icon="['fas', 'lock']"/>
            </span>
                  <span v-if="errors.password" class="icon is-small is-right">
              <font-awesome-icon :icon="['fas', 'exclamation-triangle']"/>
            </span>
                </p>
                <p v-if="errors.password" class="help is-danger">{{ errors.password[0] }}</p>
              </div>

              <div class="field">
                <p class="control">
                  <button class="button is-primary is-fullwidth" type="submit">
                    Save
                  </button>
                </p>
              </div>
            </form>

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
         avatarPicName: '',
         coverPicName: '',
         avatarSrc: '',
         coverSrc: '',
         account: {
           username: '',
           name: '',
           about: '',
           cover: '',
           avatar: '',
           email: '',
           password: ''
         },
         headers: [['Content-Type' , "multipart/form-data"]],
       }
    },

    async asyncData({$content, $axios, params}) {
      const {data} = await $axios.$get(`/profiles/${params.username}`);
      return {account : data}
    },

    created () {
      this.coverSrc =  this.account.cover;
      this.avatarSrc =  this.account.avatar;
    },

    methods: {
      previewCover() {
        this.account.cover = this.$refs.cover.files[0];
        this.coverPicName  = this.$refs.cover.files[0].name;
        let reader = new FileReader();
        reader.readAsDataURL(this.account.cover);
        reader.onload =  e => {
          this.coverSrc = e.target.result;
        }
      },

      previewAvatar() {
        this.account.avatar = this.$refs.avatar.files[0];
        this.avatarPicName = this.$refs.avatar.files[0].name;
        let reader = new FileReader();
        reader.readAsDataURL(this.account.avatar);
        reader.onload =  e => {
          this.avatarSrc = e.target.result;
        }
      },

      async edit() {
        let formData = new FormData();
        formData.append('name', this.account.name);
        formData.append('username', this.account.username);
        formData.append('about', this.account.about);
        formData.append('email', this.account.email);
        formData.append('password', this.account.password);

        if(this.avatarPicName) {
          formData.append('avatar', this.account.avatar);
        } else{
          formData.append('avatar', '');
        }

        if(this.coverPicName) {
          formData.append('cover', this.account.cover);
        } else{
          formData.append('cover', '');
        }

        formData.append('headers', this.headers);
        formData.append('_method', 'patch');

        this.$axios.post(`/profiles/${this.account.username}`, formData,  this.headers ).then(() => {
          this.$router.push({path: `/profiles/${this.post.username}`});
        }).catch(err => console.log(err))
      }

    }
  }
</script>
