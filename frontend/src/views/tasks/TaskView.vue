<script>
import gql from 'graphql-tag'
import LoaderIcon from '../../components/icons/LoaderIcon.vue'
import { RiDeleteBinLine } from 'vue-remix-icons'
export default {
  components: { LoaderIcon, RiDeleteBinLine },
  data() {
    return {
      loading: false
    }
  },
  apollo: {
    task: {
      query: gql`
        query getTask($id: ID!) {
          task(id: $id) {
            title
            description
            id
            due_date
            categories
            status
          }
        }
      `,
      variables() {
        return {
          id: this.$route.params.id
        }
      }
    }
  },
  methods: {
    deleteTask() {
      this.loading = true

      this.$apollo
        .mutate({
          mutation: gql`
            mutation deleteTask($id: ID!) {
              deleteTask(id: $id) {
                id
                title
              }
            }
          `,
          variables: {
            id: this.$route.params.id
          }
        })
        .then((data) => {
          console.log(data)
          this.loading = false
          this.$router.push({ name: 'home' })
        })
    }
  }
}
</script>
<template>
  <div class="mx-auto mt-20 flex flex-col justify-center md:mx-52">
    <div v-if="$apollo.queries.task.loading" class="mx-auto flex justify-center">
      <LoaderIcon />
    </div>
    <div v-else class="space-y-4">
      <h1 class="text-2xl font-semibold text-cyan-400">{{ task.title }}</h1>
      <div
        class="p-6 h-44 w-[20rem] flex flex-col items-start justify-around space-y-3 rounded-3xl border border-slate-200 hover:bg-gray-100 md:w-[30rem]"
      >
        <div class="flex gap-3">
          <div
            class="border text-[11px] text-center w-[78px] h-[18px] rounded-xl"
            :class="
              task.status === 'COMPLETED'
                ? 'text-cyan-500 border-cyan-300'
                : 'border-orange-300 text-orange-500'
            "
          >
            {{ task.status }}
          </div>
          <div class="text-[11px] border border-dashed border-gray-600 rounded-xl px-3">
            {{ task.categories }}
          </div>
        </div>
        <h2 class="text-xl font-semibold">{{ task.title }}</h2>
        <p>{{ task.description }}</p>
        <p class="text-sm">
          {{ task.due_date }}
        </p>
        <div class="self-end flex items-center gap-2">
          <router-link
            :to="{ name: 'update', params: { id: $route.params.id } }"
            class="bg-orange-400 px-3 py-1 rounded-xl text-white text-sm"
            >Update</router-link
          >
          <button @click="deleteTask">
            <RiDeleteBinLine class="w-5" />
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
