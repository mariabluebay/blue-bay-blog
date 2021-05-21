<template>
  <div class="block">
      <form autocomplete="off" @submit.prevent="create">
        <div class="field is-horizontal">
          <div class="field-body">
            <div class="field">
              <p class="control has-icons-right">
                <Editor
                  v-model="form.body"
                  :class="{'is-invalid':errors.body , 'has-success': true}"
                  :init="editorInit"
                  :plugins="editorPlugins"
                  :toolbar="editorToolbar"
                  api-key="qbutml30wa8s7fnzxk9f5mp0qjw55rytwpm2nxbnn9ft93wg"
                  name="editor"
                  placeholder="Comment"/>

                <span v-if="errors.body" class="icon is-small is-right">
              <font-awesome-icon :icon="['fas', 'exclamation-triangle']"/>
            </span>
              </p>
              <p v-if="errors.body" class="help is-danger">{{ errors.body[0] }}</p>
            </div>
            <div class="control">
              <button class="button is-primary" type="submit">Submit</button>
            </div>
          </div>
        </div>
      </form>
  </div>
</template>
<script>
import Editor from '@tinymce/tinymce-vue'

export default {
  name: "CreateComment",
  components: { Editor },
  props: ['slug'],
  data() {
    return {
      form: {
        body: '',
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

    async create() {

      let formData = new FormData();

      for (const prop in this.form) {
        formData.set(prop, this.form[prop]);
      }
      formData.append('slug', this.slug);

      await this.$axios.$post(`/posts/${this.slug}/comment`, formData, this.headers)
        .then(() => {
          this.$nuxt.refresh()
        })
        .catch(err => console.log(err))
    }
  }
}
</script>

<style scoped>

</style>
