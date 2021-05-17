import Vue from 'vue';
import { mapGetters } from 'vuex';

const User = {
  install ( Vue, options ) {
    Vue.mixin ({
      computed: {
        ...mapGetters( "imageHost", {
          imageHost: "url",
        })
      }
    });
  }
};

Vue.use(User);
