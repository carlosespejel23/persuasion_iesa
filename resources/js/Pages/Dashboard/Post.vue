<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Noticia } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import axios from 'axios';
import { ref, onMounted } from 'vue';

const item = ref<Noticia[]>([]);

onMounted(async () => {
  try {
    const noticias = item.value; // Arreglo de noticias
    const index = 0; // Índice del elemento del arreglo que deseas utilizar
    const id = noticias[index].id; // Extraer el valor "id" del elemento del arreglo

    const response = await axios.get(`/dashboard/show/${id}`);
    item.value = response.data;
  } catch (error) {
    console.error(error);
  }
});
</script>

<!--Aqui esta una noticia y sus comentarios-->
<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Comentarios</h2>
        </template>

        <!--Aqui va el componente de la noticia, nomas los acomodas en una tarjeta-->
        <div class="py-3" v-for="(noticia, id) in item">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <!--Aqui se hace un IF, si el usuario seleciono que el post sea anonimo remplazas el nombre por "anonimo"-->
                    <div class="p-2 text-gray-900 dark:text-gray-100" :key="id">{{ noticia.nombre }} {{ noticia.apellidoPaterno }} {{ noticia.apellidoMaterno }}</div>
                    <!--Aqui termina el IF-->

                    <!--Aqui solo das formato a la fecha-->
                    <div class="p-2 text-gray-900 dark:text-gray-100" :key="id">{{ noticia.created_at }}</div>
                    <div class="p-2 text-gray-900 dark:text-gray-100" :key="id">{{ noticia.contenido }}</div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>