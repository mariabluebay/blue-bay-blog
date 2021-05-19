<template>
    <div>
      <div class="columns is-mobile is-centered">
        <div class="column is-half">
          <ProfileCard :account="account">
            <FollowButton :account="account"/>
          </ProfileCard>
        </div>
      </div>
    </div>
</template>
<script>
import FollowButton from "../../components/FollowButton";
import ProfileCard from "../../components/ProfileCard";

export default {
  components: {ProfileCard, FollowButton },

  middleware({ store, redirect, params }) {
    let blockedUsers = store.state.auth.user.blocked_users;
    if (blockedUsers.includes(params.username)) {
      return redirect(404)
    }
  },

  async asyncData({$axios, params}) {
    const {data} = await $axios.$get(`/profiles/${params.username}`);
    return {account : data}
  },

}
</script>
