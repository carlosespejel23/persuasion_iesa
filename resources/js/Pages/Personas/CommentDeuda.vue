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

        <template #header>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight mx-auto text-center">
                Comentarios sobre los Deudores
            </h1>
        </template>

        <div v-if="cad.length === 0"><br>
          <h1 class="mt-4 text-lg text-gray-700 text-center">Este deudor aún no tiene comentarios :(</h1>
        </div>

        <div class="py-3" v-for="(comentario, id) in cad">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-2 text-gray-900" :key="id">Fecha: {{ comentario.created_at }}</div>
                    <div class="p-2 text-gray-900" :key="id">{{ comentario.comentario }}</div>
                </div>
            </div>
        </div>

    </GuestLayout>
</template>