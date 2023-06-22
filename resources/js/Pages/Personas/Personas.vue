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
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>