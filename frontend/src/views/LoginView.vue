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
        <p v-if="error" class="text-xs text-red-500 font-semibold">Incorrect Login Details</p>
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

<style scoped>
.ring {
  transform: translate(-50%, -50%);
  width: 30px;
  height: 30px;
  background: transparent;
  border: 3px solid #3c3c3c;
  border-radius: 50%;
  text-align: center;
  line-height: 80px;
  font-family: sans-serif;
  font-size: 12px;
  color: gray;
  letter-spacing: 4px;
  text-transform: uppercase;
  text-shadow: 0 0 10px gray;
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
}

.ring:before {
  content: '';
  position: absolute;
  width: 100%;
  height: 100%;
  border: 3px solid transparent;
  border-top: 3px solid cyan;
  border-right: 3px solid cyan;
  border-radius: 50%;
  animation: animateC 2s linear infinite;
}

span {
  display: block;
  position: absolute;
  top: calc(50% - 2px);
  left: 50%;
  width: 50%;
  height: 4px;
  background: transparent;
  transform-origin: left;
  animation: animate 2s linear infinite;
}

span:before {
  content: '';
  position: absolute;
  width: 16px;
  height: 16px;
  border-radius: 50%;
  background: orange;
  top: -6px;
  right: -8px;
  box-shadow: 0 0 20px orange;
}

@keyframes animateC {
  0% {
    transform: rotate(0deg);
  }

  100% {
    transform: rotate(360deg);
  }
}

@keyframes animate {
  0% {
    transform: rotate(45deg);
  }

  100% {
    transform: rotate(405deg);
  }
}
</style>
