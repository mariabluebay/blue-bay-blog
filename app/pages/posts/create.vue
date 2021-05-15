<template>
  <div class="columns is-mobile is-centered mt-6">
    <div class="column is-half has-background-light p-6 box">
      <form @submit.prevent="create" autocomplete="off" >
        <h2 class="title is-4 is-spaced bd-anchor-title has-text-centered	">
          <span>
           Create a post
          </span>
        </h2>
        <div class="field is-horizontal">
          <div class="field-body">
            <div class="field">
              <p class="control has-icons-right">
                <input v-model="form.title"
                       :class="{'is-danger':errors.title , 'is-success': true}"
                       type="text"
                       name="title"
                       class="input"
                       placeholder="Title"
                       autofocus
                       required>
                <span v-if="errors.title" class="icon is-small is-right">
                  <font-awesome-icon :icon="['fas', 'exclamation-triangle']"/>
                </span>
              </p>
              <p v-if="errors.title" class="help is-danger">{{ errors.title[0] }}</p>
            </div>

            <div class="control has-icons-left">
              <div class="select">
                <select v-model="form.audience"
                        :class="{'is-invalid':errors.audience , 'has-success': true}"
                        id="audience"
                        name="audience"
                        class="form-select"
                        required>
                  <option selected value="public">Public</option>
                  <option value="private">Private</option>
                  <option value="friends">Friends</option>
                </select>
              </div>
              <div class="icon is-small is-left">
                <font-awesome-icon :icon="['fas', 'globe']"/>
              </div>
              <p v-if="errors.audience" class="help is-danger">{{ errors.audience[0] }}</p>
            </div>
          </div>
        </div>
        <div class="field ">
          <div class="file has-name is-fullwidth">
            <label class="file-label">
              <input
                type="file"
                @change="previewFile"
                :class="{'is-danger':errors.featured , 'is-success': true}"
                ref="featured"
                name="featured"
                class="file-input">
              <span class="file-cta">
                <span class="file-icon">
                  <font-awesome-icon :icon="['fas', 'upload']"/>
                </span>
                <span class="file-label">
                  Featured image
                </span>
            </span>
              <span class="file-name">
              {{ form.imageName }}
            </span>
            </label>
            <p v-if="errors.featured" class="help is-danger">{{ errors.featured[0] }}</p>
          </div>
        </div>
        <div class="field ">
          <p class="control has-icons-right">
            <input v-model="form.excerpt"
                   :class="{'is-danger':errors.excerpt , 'is-success': true}"
                   type="text"
                   class="input"
                   name="excerpt"
                   placeholder="Excerpt"
                   required>
            <span v-if="errors.excerpt" class="icon is-small is-right">
              <font-awesome-icon :icon="['fas', 'exclamation-triangle']"/>
            </span>
          </p>
          <p v-if="errors.excerpt" class="help is-danger">{{ errors.excerpt[0] }}</p>
        </div>

        <div class="field">
          <p class="control has-icons-right">
            <Editor
              v-model="form.body"
              :class="{'is-invalid':errors.body , 'has-success': true}"
              :init="editorInit"
              :plugins="editorPlugins"
              :toolbar="editorToolbar"
              api-key="qbutml30wa8s7fnzxk9f5mp0qjw55rytwpm2nxbnn9ft93wg"
              placeholder="Content"
              name="editor"/>

            <span v-if="errors.body" class="icon is-small is-right">
              <font-awesome-icon :icon="['fas', 'exclamation-triangle']"/>
            </span>
          </p>
          <p v-if="errors.body" class="help is-danger">{{ errors.body[0] }}</p>
        </div>
        <div class="field has-addons">
          <div class="control is-expanded">
            <div class="select is-fullwidth">
              <select
                v-model="form.active"
                :class="{'is-invalid':errors.active , 'has-success': true}"
                name="active">
                <option value="1">Publish</option>
                <option value="0">Save as Draft</option>
              </select>
            </div>
          </div>
          <div class="control">
            <button type="submit" class="button is-primary">Submit</button>
          </div>
        </div>
      </form>

    </div>
  </div>
</template>

<script>

import Editor from '@tinymce/tinymce-vue'

export default {

  components: {
    Editor
  },

  middleware: ['auth'],

  data() {
    return {
      form: {
        title: '',
        excerpt: '',
        body: '',
        active: 0,
        audience: '',
        featured: Object,
        imageName: ''
      },
      headers: {'Content-Type': "multipart/form-data"},
      editorToolbar: 'undo redo | bold italic underline forecolor backcolor | \
                      alignleft aligncenter alignright alignjustify | hr bullist \
                      numlist outdent indent | link image table | code preview',
      editorPlugins: 'link image code preview imagetools table lists textcolor hr wordcount',
      editorInit: {
        height: 200,
        menubar: false,
        convert_urls: false,
        automatic_uploads: false,
        relative_urls: false,
      },
    }
  },

  methods: {
    previewFile() {
      this.form.featured = this.$refs.featured.files[0];
      this.form.imageName = this.$refs.featured.files[0].name;
    },
    async create() {

      let formData = new FormData();

      for (const prop in this.form) {
        formData.set(prop, this.form[prop]);
      }

      await this.$axios.$post('/posts', formData, this.headers)
        .then(() => {
          path: '/'
        })
        .catch(err => console.log(err))
    }
  }

}
</script>
