<template>
    <div class="min-h-screen"
    style="background-image : url('/img/bg-img2.jpg');
    background-repeat: no-repeat;
    background-size: contain;
    background-size: cover;
    "
    >
      <nav class="py-3 flex justify-between px-14 border-b border-gray-900">
        <div class="text-white">
 <!-- :style="image" -->
        </div>
        <div class="flex space-x-3 text-white">
          <router-link :to="{ name : 'Register'}" class="border px-3 py-2">Register</router-link>
          <router-link :to="{ name : 'Login'}" class="border px-3 py-2">Login</router-link>
        </div>
      </nav>
      <router-view></router-view>
    </div>
</template>
