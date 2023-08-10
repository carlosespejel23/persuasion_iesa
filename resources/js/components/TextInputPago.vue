<script setup lang="ts">
import { onMounted, ref } from 'vue';

defineProps<{
    modelValue: string;
}>();

defineEmits(['update:modelValue']);

const input = ref<HTMLInputElement | null>(null);

onMounted(() => {
    if (input.value?.hasAttribute('autofocus')) {
        input.value?.focus();
    }
});

defineExpose({ focus: () => input.value?.focus() });
</script>

<template>
      <label for="price" class="block text-lg font-medium leading-6 text-gray-900">Cantidad Recibida</label>
      <div class="relative rounded-md shadow-sm">
        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
          <span class="text-gray-500 sm:text-sm">$</span>
        </div>
        <input 
            type="text"
            :value="modelValue"
            @input="$emit('update:modelValue', ($event.target as HTMLInputElement).value)"
            ref="input" 
            name="price" 
            id="price" 
            class="block w-full rounded-md border-gray-300 pl-7 pr-20 text-gray-900 placeholder:text-gray-400 focus:border-blue-950 focus:ring-blue-950 shadow-sm" 
        />
      </div>
</template>