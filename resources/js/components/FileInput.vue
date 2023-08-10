<template>
  <input
    type="file"
    name="profile_image"
    required
    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
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
      emit('update:modelValue', file);
    };

    return {
      inputRef,
      handleFileChange,
    };
  },
};
</script>


