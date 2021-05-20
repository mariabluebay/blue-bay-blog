<template>
  <div class="media is-flex is-flex-direction-row is-justify-content-space-between">
    <div v-if="author.avatar" class="media-left is-inline-flex">
      <figure class="image is-24x24">
        <img :alt="author.username" :src="author.avatar" class="is-cover">
      </figure>
      <span class="ml-2">@{{ author.username }}</span>
    </div>
    <div class="media-right">

      <time :datetime="time">
        {{ time }}
      </time>
    </div>
  </div>

</template>

<script>
export default {
  name: "PostHeader",
  props: ['author', 'time'],
}
</script>
