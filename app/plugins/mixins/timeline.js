import Vue from 'vue';
import { mapGetters } from 'vuex';

const Timeline = {
  install ( Vue, options ) {
    Vue.mixin ({
      computed: {
        ...mapGetters({
          timeline: "timeline/timeline",
        })
      }
    });
  }
};

Vue.use ( Timeline );
