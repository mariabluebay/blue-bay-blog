<template>
  <div>
    <div class="columns is-mobile is-centered">
      <div class="column is-half">
        <ProfileCard :account="user"/>
      </div>
    </div>
  </div>

</template>
<script>
import PendingRequest from "../../components/PendingRequest";
import ProfileCard from "../../components/ProfileCard";

export default {
  components: {ProfileCard, PendingRequest },
  middleware: ['auth'],
}
</script>
