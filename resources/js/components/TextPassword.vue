<script setup lang="ts">
import { onMounted, ref } from 'vue';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faLock } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
library.add(faLock);

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

<style scoped>
    .falock{
        opacity: 50%;
    }
</style>

<template>
    
    <label for="email-address-icon" class="block mb-2 text-md font-medium text-gray-900">Contraseña</label>
    
    <div class="relative">
        <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
            <font-awesome-icon icon="fa-solid fa-lock" class="falock" />
        </div>

        <input 
            type="password" 
            id="email-address-icon" 
            class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5"
            :value="modelValue"
            @input="$emit('update:modelValue', ($event.target as HTMLInputElement).value)"
            ref="input"
        >
    </div>
</template>