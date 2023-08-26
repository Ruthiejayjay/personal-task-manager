<script>
import LoaderIcon from '../components/icons/LoaderIcon.vue'
import gql from 'graphql-tag'
import { useAuthStore } from '../stores/Auth'
import { mapStores } from 'pinia'
export default {
  components: { LoaderIcon },
  apollo: {
    me: {
      query: gql`
        query {
          me {
            name
            id
            username
          }
        }
      `
    },
    tasks: gql`
      query {
        tasks {
          data {
            id
            title
            description
            categories
            status
            due_date
            author {
              id
              name
              username
            }
          }
        }
      }
    `
  },
  computed: {
    ...mapStores(useAuthStore)
  },
  methods: {
    deleteTask() {}
  }
}
</script>

<template>
  <div class="mt-10">
    <div v-if="$apollo.queries.tasks.loading" class="mx-auto flex justify-center">
      <LoaderIcon />
    </div>
    <div v-else>
      <div v-if="authStore.isGuest" class="mx-auto flex justify-center">
        <h1 class="text-base font-semibold">You have no task. Login to Add Task</h1>
      </div>
      <div v-else>
        <div class="md:w-96 flex justify-evenly items-center">
          <h1 class="text-xl font-semibold md:ml-8">{{ me.username }} Tasks:</h1>

          <router-link
            :to="{ name: 'create' }"
            class="transition ease-in px-4 py-3 text-center cursor-pointer rounded-xl bg-slate-700 text-white hover:bg-cyan-400 hover:-translate-y-1 duration-300 btn"
          >
            Add Task
          </router-link>
        </div>

        <!-- <div v-if="tasks.data.length > 0">
        <p>You have no tasks. Add new Task</p>
        </div> -->
        <div
          class="mt-4 grid grid-cols-1 items-center justify-center gap-8 md:px-6 md:grid-cols-2 lg:grid-cols-3"
          v-if="tasks.data"
        >
          <template v-for="task in tasks.data" :key="task.id">
            <div
              class="p-6 h-36 w-[20rem] flex flex-col items-start justify-around space-y-3 rounded-3xl border border-slate-200 hover:bg-gray-100"
              v-if="task.author.id == me.id"
            >
              <div class="flex gap-3">
                <div
                  class="border text-[11px] text-center w-[78px] h-[18px] rounded-xl"
                  :class="
                    task.status === 'COMPLETED'
                      ? 'text-cyan-500 border-cyan-300'
                      : task.status === 'PENDING'
                      ? 'border-orange-300 text-orange-500'
                      : ' border-blue-300 text-blue-500'
                  "
                >
                  {{ task.status }}
                </div>
                <div class="text-[11px] border border-dashed border-gray-600 rounded-xl px-3">
                  {{ task.categories }}
                </div>
              </div>
              <router-link
                :to="{ name: 'task', params: { id: task.id } }"
                class="text-xl font-semibold hover:text-cyan-600"
                >{{ task.title }}</router-link
              >
              <p>
                {{ task.due_date }}
              </p>
            </div>
          </template>
        </div>
        <div v-else>
          <p>No Tasks. Add New Task</p>
        </div>
      </div>
    </div>
  </div>
</template>
