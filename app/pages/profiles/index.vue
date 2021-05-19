<template>
  <div>
    <div class="tile is-ancestor">
      <div class="tile is-parent is-2 is-vertical">
        <FriendsList :friends="user.pending_friend_request" :pending="true"/>
        <FriendsList :friends="user.friends" :pending="false"/>
      </div>
      <div class="tile is-parent is-6">
        <ProfileCard :account="user"/>
      </div>
    </div>
  </div>
</template>
<script>
import PendingRequest from "../../components/PendingRequest";
import ProfileCard from "../../components/ProfileCard";
import FriendsList from "../../components/FriendsList";

export default {
  components: {FriendsList, ProfileCard, PendingRequest },
  middleware: ['auth'],
}
</script>
