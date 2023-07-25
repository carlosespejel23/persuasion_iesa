<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Deudor, ComentarioActualizarDeuda } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import axios from 'axios';
import { ref, onMounted, defineProps } from 'vue';
import { library } from '@fortawesome/fontawesome-svg-core';
import {faComments} from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
library.add(faComments);

//Esto es para extraer los datos de deudores
const item = ref<Deudor[]>([]);

onMounted(async () => {
  try {
    const response = await axios.get('/deudores/show');
    item.value = response.data;
  } catch (error) {
    console.error(error);
  }
});

//Esto es para comentarios
const redirectToPost = (id: number) => {
  window.location.href = `/deudas/create/${id}`;
};
</script>

<style>
  .facom{
    font-size: 200%;
  }
</style>

<template>
    
    <Head>
        <title>
            Deudas | Persuación
        </title>
    </Head>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-center">
              Sección de Deudas
            </h2>
        </template>

        <div class="mx-auto px-10 py-10 sm:px-6 lg:max-w-7xl lg:px-8">
          <div class="grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
                <a v-for="(deudor, id) in item" class="group border-2 border-blue-950 p-5 rounded-lg duration-300 hover:scale-105 hover:shadow-xl bg-white">
                    <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-lg xl:aspect-h-8 xl:aspect-w-7">
                        <center><img src="https://persuacion.000webhostapp.com/deuda.png" width="100" /></center>
                    </div>
                    <div class="p-2 text-gray-900 dark:text-gray-100 text-center text-2xl" :key="id">Acreedor: {{ deudor.nombre }} {{ deudor.apellidoPaterno }} {{ deudor.apellidoMaterno }}</div>
                    <div class="p-2 text-gray-900 dark:text-gray-100 text-center text-2xl" :key="id">Fecha: {{ deudor.created_at }}</div>

                    <a @click="redirectToPost(deudor.id)" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                      <div align="center">
                        <font-awesome-icon icon="fa-solid fa-comments" class="facom"/>
                      </div>
                    </a>
                </a>
            </div>
        </div>
    </AuthenticatedLayout>
</template>