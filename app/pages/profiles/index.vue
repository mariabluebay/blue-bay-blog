<template>

  <div>
    <img :alt="user.name"
         src="user.cover"
         class="w-full" />
    <div class="flex justify-center -mt-8">
      <img :alt="user.name"
           :src="user.avatar"
           class="rounded-full border-solid border-white border-2 -mt-3 object-cover"
           width="150px"
      />
    </div>
    <div class="text-center px-3 pb-6 pt-2">
      <h3 class="text-black bold text-2xl mb-4">{{ user.name }}</h3>
      <div class="flex justify-center pb-3 text-grey-dark">
        <div class="text-center mr-3 border-r pr-3">
          <h2></h2>
          <span>Posts</span>
        </div>
        <div class="text-center mr-3 border-r pr-3">
          <h2></h2>
          <span>Friends</span>
        </div>
        <div class="text-center">
          <h2></h2>
          <span>Comments</span>
        </div>
      </div>
      <p class="mt-2 font-sans font-light text-grey-dark text-sm text-justify">
        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
      </p>
    </div>

    <div class="flex justify-between">
      <div> Joined {{ user.created_at }}</div>
      @auth
      <div class="text-left">

        <a href=""
           class="bg-white border rounded-lg p-2 text-black text-xs">
          Edit Profile</a>


      </div>
      @endauth
    </div>



    <hr class="block py-4 mt-4">
  </div>
</template>
