<script>
import { ButtonComponent } from '../../components/reusables'
import LoaderIcon from '../../components/icons/LoaderIcon.vue'
import { RiArrowLeftLine } from 'vue-remix-icons'
import Multiselect from '@vueform/multiselect'
import gql from 'graphql-tag'
export default {
  components: {
    ButtonComponent,
    LoaderIcon,
    Multiselect,
    RiArrowLeftLine
  },
  data() {
    return {
      loading: false,
      title: '',
      description: '',
      due_date: '',
      categories: '',
      status: '',
      error: null,
      categoryoptions: ['PERSONAL', 'WORK', 'OTHER'],
      statusoptions: ['INPROGRESS', 'PENDING', 'COMPLETED']
    }
  },
  watch: {
    task(newTask) {
      this.title = newTask.title
      this.description = newTask.description
      this.status = newTask.status
      this.categories = newTask.categories
      this.due_date = newTask.due_date
    }
  },
  apollo: {
    // Simple query that will update the 'hello' vue property
    task: {
      query: gql`
        query getTask($id: ID!) {
          task(id: $id) {
            title
            description
            id
            categories
            status
            due_date
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
    updateTask() {
      this.loading = true
      this.error = null
      this.$apollo
        .mutate({
          mutation: gql`
            mutation updateTask($id: ID!, $input: TaskInput!) {
              updateTask(id: $id, input: $input) {
                title
                description
                categories
                status
                due_date
              }
            }
          `,
          variables: {
            id: this.$route.params.id,
            input: {
              title: this.title,
              description: this.description,
              categories: this.categories,
              due_date: this.due_date,
              status: this.status
            }
          }
        })
        .then((data) => {
          console.log(data)
          this.loading = false
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
    <div class="border rounded-xl p-8 space-y-5 md:p-12">
      <div class="mx-auto flex justify-center" v-if="loading">
        <LoaderIcon />
      </div>
      <router-link :to="{ name: 'home' }" class="flex items-center font-semibold">
        <RiArrowLeftLine class="w-6" />
        Back
      </router-link>
      <h1 class="text-xl font-semibold">Update Task</h1>
      <form @submit.prevent="updateTask" class="mt-5 flex flex-col space-y-6">
        <!-- {{ error }} -->
        <p v-if="error" class="text-xs text-red-500 font-semibold">Incorrect Task details</p>
        <div class="flex flex-col md:space-x-4 md:flex-row">
          <div class="flex flex-col">
            <label for="title">Title</label>
            <input
              type="text"
              name="title"
              id="title"
              placeholder="Enter Task Title"
              v-model="title"
              required
              class="h-10 pl-2 border border-gray-400 rounded-md focus:outline-none"
            />
          </div>
          <div class="flex flex-col mt-4 md:mt-0">
            <label for="due_date">Due Date</label>
            <input
              type="date"
              name="due_date"
              id="due_date"
              v-model="due_date"
              required
              class="h-10 pl-2 border border-gray-400 rounded-md focus:outline-none"
            />
          </div>
        </div>
        <div class="flex flex-col">
          <label for="categories">Status</label>

          <Multiselect
            :options="statusoptions"
            track-by="categories"
            label="status"
            placeholder="Update Status"
            :searchable="false"
            :allow-empty="false"
            v-model="status"
            name="status"
          />
        </div>
        <div class="flex flex-col">
          <label for="categories">Categories</label>

          <Multiselect
            :options="categoryoptions"
            track-by="categories"
            label="categories"
            placeholder="Select one Category"
            :searchable="false"
            :allow-empty="false"
            v-model="categories"
            name="categories"
          />
        </div>
        <div class="flex flex-col">
          <label for="description">Description</label>
          <textarea
            v-model="description"
            name="description"
            id="description"
            cols="30"
            rows="5"
            required
            class="pt-2 pl-6 border border-gray-400 rounded-md focus:outline-none"
          ></textarea>
        </div>
        <div
          class="transition ease-in w-full h-9 cursor-pointer rounded-xl bg-slate-700 text-white hover:bg-cyan-400 hover:-translate-y-1 duration-300 btn"
        >
          <ButtonComponent type="submit" loading-class="rounded-[5rem]">
            Update Task
          </ButtonComponent>
        </div>
      </form>
    </div>
  </div>
</template>
<style src="@vueform/multiselect/themes/default.css"></style>
