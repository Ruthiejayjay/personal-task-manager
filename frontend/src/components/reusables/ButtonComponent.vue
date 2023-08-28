<script setup>
defineProps({
  type: {
    type: String,
    default: 'button'
  },
  text: {
    type: String,
    default: 'Add New'
  },
  loadingClass: {
    type: String,
    default: 'bg-[#bba9fd]'
  },
  loading: {
    type: Boolean,
    default: false
  },
  disabled: {
    type: Boolean,
    default: false
  },
  customClass: {
    type: String,
    default: 'font-normal'
  },
  style: {
    type: Object
  }
})
</script>
<template>
  <button
    class="m-0 flex h-full w-full items-center justify-center overflow-hidden rounded-[inherit] border-inherit bg-inherit ring-inherit"
    :type="type"
    :style="style"
    :class="customClass"
    :disabled="disabled"
  >
    <div v-if="disabled === false" @click="$emit('click')" class="block px-[inherit] py-[inherit]">
      <slot>Button text</slot>
    </div>
    <div
      v-else
      :class="loadingClass"
      class="flex h-full w-full cursor-not-allowed items-center justify-center gap-x-2 md:gap-x-2"
    >
      <slot>Button text</slot>
    </div>
  </button>
</template>
