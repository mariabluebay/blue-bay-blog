<template>
  <div>
    <div v-for="comment in comments">
      <PostHeader
        :author="comment.author"
        :time="comment.created_at"
      />
      <div v-html="comment.body"></div>
      <hr/>
    </div>
  </div>
</template>

<script>
import PostHeader from "./PostHeader";
export default {
  name: "CommentsList",
  components: { PostHeader },
  props: [
    'comments'
  ]
}
</script>

<style scoped>

</style>
