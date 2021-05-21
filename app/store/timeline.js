export const state = () => ({
  timeline: { },
})

export const getters = {
  timeline ( state ){
    return state.timeline;
  }
}

export const mutations = {
  UPDATE_TIMELINE( state, timeline ) {
    state.timeline = timeline;
  }
}

export const actions = {
  updateTimeline({ commit }, timeline) {
    commit('UPDATE_TIMELINE', timeline);
  }
}
