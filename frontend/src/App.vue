<script>
import { RouterLink, RouterView } from 'vue-router'
import { RiMenuFill } from 'vue-remix-icons'
import { useAuthStore } from './stores/Auth'
import { mapStores } from 'pinia'
import gql from 'graphql-tag'
export default {
  components: { RiMenuFill },
  data() {
    return {
      showMenu: false
    }
  },
  computed: {
    ...mapStores(useAuthStore)
  },
  methods: {
    toggleNavbar: function () {
      this.showMenu = !this.showMenu
    },
    logout() {
      this.$apollo
        .mutate({
          mutation: gql`
            mutation logout {
              logout {
                message
              }
            }
          `
        })
        .then((data) => {
          localStorage.removeItem('apollo-token')
          window.location.href = '/'
        })
        .catch((error) => {
          console.log(error)
        })
    }
  }
}
</script>

<template>
  <header class="relative flex flex-wrap items-center justify-between">
    <div class="container mx-auto flex items-center justify-between">
      <div
        class="w-full relative flex justify-between md:w-auto md:static md:block md:justify-start"
      >
        <RouterLink to="/" class="text-lg font-bold text-gray-600 md:text-2xl"
          >Personal Task Manager</RouterLink
        >
      </div>

      <button
        class="text-black cursor-pointer leading-none border border-solid border-transparent rounded bg-transparent block md:hidden outline-none focus:outline-none"
        type="button"
        v-on:click="toggleNavbar()"
      >
        <RiMenuFill class="w-8" />
      </button>
      <div
        class="md:flex md:flex-grow md:space-x-2 space-y-2"
        v-bind:class="{ hidden: !showMenu, flex: showMenu }"
      >
        <nav class="flex flex-col md:flex-row list-none ml-auto">
          <RouterLink
            to="/"
            class="transition ease-in w-[5rem] h-9 cursor-pointer rounded-xl text-base flex items-center justify-center active:text-blue-400 text-gray-500 hover:-translate-y-1 duration-300"
          >
            Home</RouterLink
          >
          <RouterLink
            v-if="authStore.isGuest"
            to="/login"
            class="transition ease-in w-[5rem] h-9 cursor-pointer rounded-xl text-base flex items-center justify-center text-gray-500 hover:-translate-y-1 duration-300"
          >
            Login</RouterLink
          >
          <RouterLink
            v-if="authStore.isGuest"
            to="/register"
            class="transition ease-in w-[5rem] h-9 cursor-pointer rounded-xl text-base flex items-center justify-center text-gray-500 hover:-translate-y-1 duration-300"
          >
            Register</RouterLink
          >
          <a
            class="transition ease-in w-[5rem] h-9 cursor-pointer rounded-xl text-base flex items-center justify-center text-gray-500 hover:-translate-y-1 duration-300"
            @click.prevent="logout"
            v-if="authStore.isLoggedIn"
          >
            Logout</a
          >
        </nav>
      </div>
    </div>
  </header>

  <RouterView />
</template>
<style scoped>
nav a.router-link-exact-active {
  color: cyan;
}
</style>
