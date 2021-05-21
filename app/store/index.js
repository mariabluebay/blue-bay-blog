export const state = () => ({
  auth: { },
})

export const mutations = {
  UPDATE_FRIENDS( state, friends ) {
    state.auth.user.friends = friends;
  },
  UPDATE_FRIENDS_COUNT( state, count ) {
    state.auth.user.friends_count = count;
  },
  UPDATE_PENDING_FRIENDS( state, friends ) {
    state.auth.user.pending_friend_request = friends;
  },
  UPDATE_FOLLOWS( state, friends ) {
    state.auth.user.follows = friends;
  },
  UPDATE_PROFILE(state, profile) {
    state.auth.user = profile;
  }
}

export const actions = {
  updateFriends( { commit }){
    this.$axios.get('/user').then((response) => {
      commit('UPDATE_FRIENDS', response.data.data.friends);
      commit('UPDATE_FRIENDS_COUNT', response.data.data.friends_count);
      commit('UPDATE_PENDING_FRIENDS', response.data.data.pending_friend_request);
      commit('UPDATE_FOLLOWS', response.data.data.follows);
    })
  },

  updateProfile( { commit }, profile){
    commit('UPDATE_PROFILE', profile.data);
  }
}
