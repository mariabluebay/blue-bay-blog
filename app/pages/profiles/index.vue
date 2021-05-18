<template>
  <div>
    <img
      :alt="account.name"
      :src="account.cover"
      class="w-full"/>
    <div>
      <img :alt="account.name"
           :src="account.avatar"
           class=""
           width="150px"
      />
    </div>
    <div >
      <h3 >{{ account.name }}</h3>
      <div >
        <div>
          <h2>{{ account.posts_count }}</h2>
          <span>Posts</span>
        </div>
        <div >
          <h2>{{ account.followers_count }}</h2>
          <span>Friends</span>
        </div>
        <div >
          <h2>{{ account.follows }}</h2>
          <span>Comments</span>
        </div>
      </div>
      <p class="mt-2 font-sans font-light text-grey-dark text-sm text-justify">
        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's
        standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make
        a type specimen book.
      </p>
    </div>
    <div>
      <div> Joined {{ account.created_at }}</div>
      <PendingRequest :requests="account.pending_friend_request"/>
    </div>
    <hr class="block py-4 mt-4">
  </div>
</template>
<script>
import PendingRequest from "../../components/PendingRequest";

export default {
  components: { PendingRequest },
  middleware: ['auth'],
  async asyncData({$axios, store}) {
    const {data} = await $axios.$get(`/profiles/${store.state.auth.user.username}`);
    return {account : data}
  },
}
</script>
