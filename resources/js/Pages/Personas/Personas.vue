<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { User } from '@/types';
import { Head } from '@inertiajs/vue3';
import axios from 'axios';
import { ref, onMounted} from 'vue';

//Esto es para extraer los datos de deudores
const item = ref<User[]>([]);

onMounted(async () => {
  try {
    const response = await axios.get('/personas/show');
    item.value = response.data;
  } catch (error) {
    console.error(error);
  }
});

//Esto es para mandar la URL de cada usuario a su perfil
const redirectToPost = (id: number) => {
  window.location.href = `/personas/show/user/${id}`;
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Seccion de Personas</h2>
        </template>
        
        <!--Aqui va el componente de la noticia, nomas los acomodas en una tarjeta-->
        <div class="py-3" v-for="(user, id) in item">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <!--Esta es la informacion del deudor-->
                    <div class="p-2 text-gray-900 dark:text-gray-100" :key="id">{{ user.nombre }} {{ user.apellidoPaterno }} {{ user.apellidoMaterno }}</div>
                    <a @click="redirectToPost(user.id)" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                        Ver Perfil
                    </a>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>