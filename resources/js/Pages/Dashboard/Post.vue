<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Noticia } from '@/types';
import { Head } from '@inertiajs/vue3';
import axios from 'axios';
import { ref, onMounted, Ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';

const item: Ref<Noticia | null> = ref(null);
//const route = useRoute();
//const noticiaId = route.params.id;

const router = useRouter();
const noticiaId = router.currentRoute.value.params.id;

onMounted(async () => {
  try {
    const response = await axios.get(`/dashboard/show/${noticiaId}`);
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
        <div class="py-3">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <!--Aqui se hace un IF, si el usuario seleccionó que el post sea anónimo reemplazas el nombre por "anónimo"-->
                    <div class="p-2 text-gray-900 dark:text-gray-100">{{ item?.nombre }} {{ item?.apellidoPaterno }} {{ item?.apellidoMaterno }}</div>
                    <!--Aqui termina el IF-->

                    <!--Aqui solo das formato a la fecha-->
                    <div class="p-2 text-gray-900 dark:text-gray-100">{{ item?.created_at }}</div>
                    <div class="p-2 text-gray-900 dark:text-gray-100">{{ item?.contenido }}</div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>