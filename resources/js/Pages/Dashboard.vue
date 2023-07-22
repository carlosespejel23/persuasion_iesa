<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Noticia } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import axios from 'axios';
import { ref, onMounted, defineProps } from 'vue';
import ReactionsComponent from '@/components/ReactionsComponent.vue';
import { library } from '@fortawesome/fontawesome-svg-core';
import {faNewspaper} from '@fortawesome/free-regular-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
library.add(faNewspaper);

//Esto es para extraer las noticias
const item = ref<Noticia[]>([]);

onMounted(async () => {
  try {
    const response = await axios.get('/dashboard/showAll');
    item.value = response.data;
  } catch (error) {
    console.error(error);
  }
});

//Esto es para mandar la URL de cada noticia a los comentarios
const redirectToPost = (id: number) => {
  window.location.href = `/dashboard/show/${id}`;
};
</script>

<template>
    
    <Head>
        <title>
            Noticias | Persuación
        </title>
    </Head>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-center">Seccion de Noticias</h2>
        </template>

        <div class="mx-auto px-10 py-5 sm:px-6 lg:max-w-7xl lg:px-8">
            <div class="mb-5">
                <Link :href="route('dashboard.create')">
                    <button class="bg-white text-gray-800 font-bold rounded border-b-2 border-blue-950 hover:border-blue-950 hover:bg-blue-950 hover:text-white shadow-md py-2 px-6 inline-flex items-center">
                        <span class="mr-2">Crear Nueva Noticia</span>
                        <font-awesome-icon icon="fa-regular fa-newspaper" />
                    </button>
                </Link>
            </div>

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
                        
                        <!--Aqui le pones un boton o algo que quiera para que vea los comentarios, este solo es para direcionar la pagina-->
                        <!--El contenido de la etiqueta es un ejemplo, a mi no me sirve routerlink-->
                        <a @click="redirectToPost(noticia.id)" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            Comentarios
                        </a>
                        <ReactionsComponent :post-id="noticia.id"></ReactionsComponent>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
