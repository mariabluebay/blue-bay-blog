<template>
  <div class="tile is-child">
    <nav class="pagination" role="navigation" aria-label="pagination">
      <ul class="pagination-list">
        <li v-for="(key, value) in links">
          <a
            @click="loadMore(key, value)"
            class="pagination-link"
            aria-current="page"
            :disabled="isDisabled(value)"
          >
            {{ value }}
          </a>

        </li>
      </ul>
    </nav>
  </div>
</template>

<script>
export default {
  name: "Pagination",
  props: [
    'links',
    'meta'
  ],
  methods: {
    async loadMore(key, value) {
      let res = await this.$axios.$get(key)
      this.$store.dispatch('timeline/updateTimeline', res);
    },

    isDisabled(value){
      if(value == 'prev' && this.meta.current_page == 1){
        return 'disabled';
      }else if (value == 'next' && this.meta.last_page == this.meta.current_page){
        return 'disabled';
      }
    }
  }
}
</script>

<style scoped>

</style>
