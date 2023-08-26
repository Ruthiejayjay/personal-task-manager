import { defineStore } from 'pinia'

export const useAuthStore = defineStore('auth', {
  state: () => {
    return {
      user: {}
    }
  },

  getters: {
    isLoggedIn() {
      return this.getAccessToken() !== null
    },

    isGuest() {
      return !this.isLoggedIn
    }
  },

  actions: {
    setUser(user) {
      this.user = user
    },

    getAccessToken() {
      return localStorage.getItem('apollo-token')
    }
  }
})
