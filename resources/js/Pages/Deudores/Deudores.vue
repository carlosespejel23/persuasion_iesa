<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Deudor } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import axios from 'axios';
import { ref, onMounted, defineProps } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { library } from '@fortawesome/fontawesome-svg-core';
import {faUserPlus, faTrash} from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
library.add(faUserPlus, faTrash);

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

//Esto es para eliminar un deudor
const redirectToPost = (id: number) => {
  window.location.href = `/deudores/${id}`;
};

</script>

<template>

    <Head>
        <title>
            Deudores | Persuación
        </title>
    </Head>

    <AuthenticatedLayout>
        
        <template #header>
            <h1 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mx-auto text-center">
                Seccion de Deudores
            </h1>
        </template>
        

        <!--Aqui va el componente de la noticia, nomas los acomodas en una tarjeta-->
        <div class="mx-auto px-10 py-5 sm:px-6 lg:max-w-7xl lg:px-8">

            <div class="mb-5">
                <Link :href="route('deudores.create')">
                    <button class="bg-white text-gray-800 font-bold rounded border-b-2 border-blue-950 hover:border-blue-950 hover:bg-blue-950 hover:text-white shadow-md py-2 px-6 inline-flex items-center">
                        <span class="mr-2">Agregar Deudor</span>
                        <font-awesome-icon icon="user-plus" />
                    </button>
                </Link>
            </div>
            
            <div class="grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
                <a v-for="(deudor, id) in item" class="group border-2 border-blue-950 p-5 rounded-lg duration-300 hover:scale-105 hover:shadow-xl bg-white">
                    <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-lg xl:aspect-h-8 xl:aspect-w-7">
                        <center><img src="https://cdn-icons-png.flaticon.com/512/2361/2361562.png" width="100" /></center>
                    </div>
                    <h1 class="mt-4 text-lg text-black text-center" :key="id">{{ deudor.nombre }} {{ deudor.apellidoPaterno }} {{ deudor.apellidoMaterno }}</h1>
                    <br>
                    <center>
                        <a @click="redirectToPost(deudor.id)" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            <button class="bg-white text-gray-800 font-bold rounded border-b-2 border-red-400 hover:border-red-950 hover:bg-red-950 hover:text-white shadow-md py-2 px-6 inline-flex items-center">
                                <span class="mr-2">Eliminar Deudor</span>
                                <font-awesome-icon icon="fa-solid fa-trash" />
                            </button>
                        </a>
                    </center>
                </a>
            </div>
            
        </div>
    </AuthenticatedLayout>
</template>