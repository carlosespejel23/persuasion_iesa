<template>
  <input
    type="file"
    name="profile_image"
    required
    class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
    @change="handleFileChange"
    ref="input"
  />
</template>

<script lang="ts">
import { ref, defineEmits } from 'vue';

export default {
  name: 'FileInput',
  emits: ['update:modelValue'],
  setup(_, { emit }) {
    const inputRef = ref<HTMLInputElement | null>(null);

    const handleFileChange = (event: Event) => {
      const file = (event.target as HTMLInputElement).files?.[0] || null;
      console.log('form.profile_image:', file);
      emit('update:modelValue', file);
    };

    return {
      inputRef,
      handleFileChange,
    };
  },
};
</script>


