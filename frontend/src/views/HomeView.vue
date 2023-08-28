<script>
import { LoaderIcon, ArrowIcon } from '../components/icons'
import gql from 'graphql-tag'
import { RiSearchLine } from 'vue-remix-icons'
import { useAuthStore } from '../stores/Auth'
import { mapStores } from 'pinia'
export default {
  components: { LoaderIcon, RiSearchLine, ArrowIcon },
  data() {
    return {
      tasks: [],
      loading: false
    }
  },
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
    }
  },
  computed: {
    ...mapStores(useAuthStore),
    handleSearch() {
      if (this.search.trim().length > 0) {
        return this.tasks.filter((task) =>
          (task.title || task.description).toLowerCase().includes(this.search.trim().toLowerCase())
        )
      }
      return this.tasks
    }
  },
  methods: {
    getAllTasks() {
      this.loading = true
      const baseUrl = import.meta.env.VITE_API_URL
      fetch(baseUrl, {
        method: 'POST',
        headers: {
          'Content-Type': 'Application/json'
        },
        body: JSON.stringify({
          query: `
            query {
              tasks{
                data {
                  id
                  title
                  status
                  description
                  due_date
                  categories
                  author{
                    id
                  } 
                }
              }
            }
          `
        })
      })
        .then((res) => res.json())
        .then((result) => {
          this.loading = false
          this.tasks = result.data.tasks.data
        })
    },
    handleStatusChange(event) {
      const status = event.target.value
      if (status == 'Tasks') {
        return this.getAllTasks()
      } else {
        return this.getTasksByStatus(status)
      }
    },
    handleCategoryFilter(event) {
      const category = event.target.value
      if (category == 'Tasks') {
        return this.getAllTasks()
      } else {
        return this.getTasksByCategory(category)
      }
    },
    getTasksByCategory(category) {
      this.loading = true
      const baseUrl = import.meta.env.VITE_API_URL
      fetch(baseUrl, {
        method: 'POST',
        headers: {
          'Content-Type': 'Application/json'
        },
        body: JSON.stringify({
          query: `
            query {
              tasksByCategory(categories: ${category}){
                data {
                  id
                  title
                  status
                  description
                  due_date
                  categories
                  author{
                    id
                  } 
                }
              }
            }
          `
        })
      })
        .then((res) => res.json())
        .then((result) => {
          this.loading = false
          this.tasks = result.data.tasksByCategory.data
        })
    },
    getTasksByStatus(status) {
      this.loading = true
      const baseUrl = import.meta.env.VITE_API_URL
      fetch(baseUrl, {
        method: 'POST',
        headers: {
          'Content-Type': 'Application/json'
        },
        body: JSON.stringify({
          query: `
            query {
              tasksByStatus(status: ${status}){
                data {
                  id
                  title
                  status
                  description
                  due_date
                  categories
                  author{
                    id
                  } 
                }
              }
            }
          `
        })
      })
        .then((res) => res.json())
        .then((result) => {
          this.loading = false
          this.tasks = result.data.tasksByStatus.data
        })
    },
    shouldNotify(task) {
      const taskDueDate = new Date(task.due_date)
      const today = new Date()
      const notify =
        today.getDate() === taskDueDate.getDate() &&
        today.getMonth() === taskDueDate.getMonth() &&
        today.getFullYear() == taskDueDate.getFullYear()
      return notify
    }
  },
  mounted() {
    this.getAllTasks()
  }
}
</script>

<template>
  <div class="mt-10">
    <div v-if="loading || $apollo.queries.me.loading" class="mx-auto flex justify-center">
      <LoaderIcon />
    </div>
    <div else>
      <div v-if="authStore.isGuest" class="mx-auto mt-12 flex justify-center">
        <h1 class="text-lg font-semibold">You have no task. Login to Add Task</h1>
      </div>
      <div v-else>
        <div class="flex justify-between items-center flex-col gap-y-4 md:flex-row md:mx-16">
          <div class="flex justify-evenly items-center gap-x-6">
            <h1 class="text-xl font-semibold md:ml-8">{{ me.username }} Tasks:</h1>

            <router-link
              :to="{ name: 'create' }"
              class="transition ease-in px-4 py-3 text-center cursor-pointer rounded-xl bg-slate-700 text-white hover:bg-cyan-400 hover:-translate-y-1 duration-300 btn"
            >
              Add Task
            </router-link>
          </div>
          <div class="flex space-x-2">
            <div
              class="relative flex lg:inline-flex items-center bg-gray-100 rounded-xl focus:outline-none"
            >
              <select
                @change="handleCategoryFilter"
                class="flex-1 appearance-none bg-transparent py-2 pl-3 pr-9 text-sm font-semibold focus:outline-none"
              >
                <option value="Tasks" selected>Categories</option>
                <option value="WORK">Work</option>
                <option value="PERSONAL">Personal</option>
                <option value="OTHER">Other</option>
              </select>
              <ArrowIcon />
            </div>
            <div
              class="relative flex lg:inline-flex items-center bg-gray-100 rounded-xl focus:outline-none"
            >
              <select
                @change="handleStatusChange"
                class="flex-1 appearance-none bg-transparent py-2 pl-3 pr-9 text-sm font-semibold focus:outline-none"
              >
                <option value="Tasks" selected>Status</option>
                <option value="PENDING">Pending</option>
                <option value="INPROGRESS">In-Progress</option>
                <option value="COMPLETED">Completed</option>
              </select>
              <ArrowIcon />
            </div>
          </div>
        </div>

        <div
          class="mt-8 mx-auto grid grid-cols-1 items-center justify-center gap-y-8 md:px-6 md:mx-16 md:grid-cols-2 lg:grid-cols-3"
        >
          <template v-for="task in tasks" :key="task.id">
            <div
              class="p-6 h-36 w-[20rem] flex flex-col items-start justify-around space-y-3 rounded-3xl border border-slate-200 hover:bg-gray-100"
              v-if="task.author.id == me.id"
            >
              <div class="flex justify-between items-center space-x-20">
                <div class="flex gap-2">
                  <div
                    class="border text-[11px] text-center py-1 px-2 rounded-xl"
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
                  <div
                    class="text-[11px] border border-dashed border-gray-600 rounded-xl py-1 px-2"
                  >
                    {{ task.categories }}
                  </div>
                </div>
                <div
                  v-if="shouldNotify(task) && task.status != 'COMPLETED'"
                  class="text-[11px] border bg-red-400 border-transparent text-white rounded-xl py-1 px-2 animate-bounce"
                >
                  Due
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
      </div>
    </div>
  </div>
</template>
