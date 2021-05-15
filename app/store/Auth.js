export const getters = {
  authenticated ( state, getters, rootState ) {
    return rootState.auth.loggedIn;
  },

  user ( state, getters, rootState ) {
    return rootState.auth.user;
  }
};
