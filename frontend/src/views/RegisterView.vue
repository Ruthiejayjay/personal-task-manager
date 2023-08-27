<script>
import gql from 'graphql-tag'
import { ButtonComponent } from '../components/reusables'
import LoaderIcon from '../components/icons/LoaderIcon.vue'
export default {
  components: {
    ButtonComponent,
    LoaderIcon
  },
  data() {
    return {
      name: '',
      username: '',
      email: '',
      password: '',
      password_confirmation: '',
      error: null,
      loading: false
    }
  },
  methods: {
    register() {
      this.loading = true
      this.$apollo
        .mutate({
          mutation: gql`
            mutation login($input: RegisterInput!) {
              register(input: $input) {
                token
              }
            }
          `,
          variables: {
            input: {
              name: this.name,
              username: this.username,
              email: this.email,
              password: this.password,
              password_confirmation: this.password_confirmation
            }
          }
        })
        .then((data) => {
          console.log(data)
          this.loading = false
          localStorage.setItem('apollo-token', data.data.register.token)
          window.location.href = '/tasks/create'
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
      <h1 class="text-xl font-semibold">Register Form</h1>
      <form @submit.prevent="register" class="mt-5 flex flex-col space-y-4 w-full">
        <p v-if="error" class="text-xs text-red-500 font-semibold">Incorrect Register Details</p>
        <div class="flex justify-between gap-x-4">
          <input
            type="text"
            name="name"
            v-model="name"
            placeholder="Name"
            class="h-10 pl-2 border border-gray-400 rounded-md focus:outline-none"
            required
          />
          <input
            type="text"
            name="username"
            v-model="username"
            placeholder="Username"
            required
            class="h-10 pl-2 border border-gray-400 rounded-md focus:outline-none"
          />
        </div>
        <input
          type="email"
          name="email"
          v-model="email"
          placeholder="Email"
          required
          class="h-10 pl-2 border border-gray-400 rounded-md focus:outline-none"
        />

        <input
          type="password"
          name="password"
          v-model="password"
          placeholder="Password"
          required
          class="h-10 pl-2 border border-gray-400 rounded-md focus:outline-none"
        />

        <input
          type="password"
          name="confirmPassword"
          v-model="password_confirmation"
          placeholder="Confirm Password"
          required
          class="h-10 pl-2 border border-gray-400 rounded-md focus:outline-none"
        />

        <div
          class="transition ease-in w-full h-9 cursor-pointer rounded-xl bg-slate-700 text-white hover:bg-cyan-400 hover:-translate-y-1 duration-300 btn"
        >
          <ButtonComponent type="submit" loading-class="rounded-[5rem]"> Register </ButtonComponent>
        </div>
        <p class="text-xs">
          Already a user.
          <router-link :to="{ name: 'login' }" class="font-bold"> Login </router-link>
        </p>
      </form>
    </div>
  </div>
</template>
