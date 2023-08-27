<script>
import { ButtonComponent } from '../components/reusables'
import LoaderIcon from '../components/icons/LoaderIcon.vue'
import gql from 'graphql-tag'
export default {
  components: {
    ButtonComponent,
    LoaderIcon
  },
  data() {
    return {
      email: '',
      password: '',
      error: null,
      loading: false
    }
  },
  methods: {
    login() {
      this.loading = true
      this.$apollo
        .mutate({
          mutation: gql`
            mutation login($input: LoginInput!) {
              login(input: $input) {
                token
              }
            }
          `,
          variables: {
            input: {
              email: this.email,
              password: this.password
            }
          }
        })
        .then((data) => {
          console.log(data)
          this.error = null
          this.loading = false
          localStorage.setItem('apollo-token', data.data.login.token)
          window.location.href = '/'
        })
        .catch((error) => {
          console.log(error.graphQLErrors[0].message)
          this.loading = false
          this.error = error.graphQLErrors[0].message
        })
    }
  }
}
</script>

<template>
  <div class="mt-12 grid place-items-center">
    <div class="border rounded-xl p-8 md:p-12">
      <div class="mx-auto flex justify-center" v-if="loading">
        <LoaderIcon />
      </div>
      <h1 class="text-xl font-semibold">Login Form</h1>
      <form @submit.prevent="login" class="mt-5 flex flex-col space-y-4">
        <!-- {{ error }} -->
        <p v-if="error" class="text-xs text-red-500 font-semibold">{{ error }}</p>
        <div class="flex flex-col">
          <input
            type="email"
            name="email"
            placeholder="Email"
            v-model="email"
            class="h-10 pl-2 border border-gray-400 rounded-md focus:outline-none"
          />
        </div>
        <div class="flex flex-col">
          <input
            type="password"
            name="password"
            placeholder="Password"
            v-model="password"
            class="h-10 pl-2 border border-gray-400 rounded-md focus:outline-none"
          />
        </div>

        <div
          class="transition ease-in w-full h-9 cursor-pointer rounded-xl bg-slate-700 text-white hover:bg-cyan-400 hover:-translate-y-1 duration-300 btn"
        >
          <ButtonComponent type="submit" loading-class="rounded-[5rem]"> Login </ButtonComponent>
        </div>
        <p class="text-xs">
          Not a user.
          <router-link :to="{ name: 'register' }" class="font-bold"> Register </router-link>
        </p>
      </form>
    </div>
  </div>
</template>
