<script setup lang="ts">
import GuestLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { ComentarioDeudaPago } from '@/types';
import axios from 'axios';
import { ref, onMounted } from 'vue';

//Esto es para extraer los comentarios en los deudores
const cad = ref<ComentarioDeudaPago[]>([]);
const uri = new URL(window.location.href);
const id = uri.pathname.split('/').pop();

onMounted(async () => {
  try {
    const response = await axios.get(`/personas/showCommentDeuda/${id}`);
    cad.value = response.data;
  } catch (error) {
    console.error(error);
  }
});
</script>

<template>
    <GuestLayout>
        <Head title="Comentarios" />

        <div class="py-3" v-for="(comentario, id) in cad">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-2 text-gray-900 dark:text-gray-100" :key="id">{{ comentario.created_at }}</div>
                    <div class="p-2 text-gray-900 dark:text-gray-100" :key="id">{{ comentario.comentario }}</div>
                </div>
            </div>
        </div>

    </GuestLayout>
</template>