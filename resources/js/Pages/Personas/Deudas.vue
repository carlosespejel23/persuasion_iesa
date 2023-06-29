<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Deudor, User } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import axios from 'axios';
import { ref, onMounted, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

//Esto es para extraer las deudas
const deudas = ref<Deudor[]>([]);
const uri = new URL(window.location.href);
const id = uri.pathname.split('/').pop();

onMounted(async () => {
  try {
    const response = await axios.get(`/personas/showDeuda/${id}`);
    deudas.value = response.data;
  } catch (error) {
    console.error(error);
  }
});

//Esto es para mandar la URL de cada usuario a las deudas
const redirectToDeudas = (id: number) => {
  window.location.href = `/personas/show/deudas/${id}`;
};

//Esto es para mandar la URL de cada usuario a su perfil principal
const redirectToPerfil = (id: number) => {
  window.location.href = `/personas/show/user/${id}`;
};

//Extraccion de los datos del perfil
const page = usePage();
const user = ref<User | null>(page.props.user as User || null);

//Comentarios de la deuda
const redirectToComment = (id: number) => {
  window.location.href = `/personas/showComment/Deuda/${id}`;
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <!--Le agregas la foto de perfil, y le pones formato pa' que se vea vrgas-->
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Perfil del usuario: {{ user?.nombre }} {{ user?.apellidoPaterno }} {{ user?.apellidoMaterno }}</h2>
        </template>

        <!--Aqui va el componente de la noticia, nomas los acomodas en una tarjeta-->
        <div class="py-3">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-2 text-gray-900 dark:text-gray-100" :key="id">INFORMACION</div>
                    <div class="p-2 text-gray-900 dark:text-gray-100" :key="id">Correo Electronico: {{ user?.email }}</div>
                    <div class="p-2 text-gray-900 dark:text-gray-100" :key="id">Telefono: {{ user?.telefono }}</div>
                    <div class="p-2 text-gray-900 dark:text-gray-100" :key="id">Se unio: {{ user?.created_at }}</div>
                </div>
            </div>
        </div>

        <!--Si quieres aqui haces un mini menu-->
        <a @click="redirectToDeudas(user.id)" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
            Sección Deudas
        </a><br>
        <a @click="redirectToPerfil(user.id)" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
            Publicaciones
        </a>

        <hr>
        <br>

        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-center">Deudores y Pagos</h2>

        <!--Aqui va el componente de la noticia, nomas los acomodas en una tarjeta-->
        <div class="py-3" v-for="(deudor, id) in deudas">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <!--Esta es la informacion del deudor-->
                    <div class="p-2 text-gray-900 dark:text-gray-100" :key="id">{{ deudor.nombre }} {{ deudor.apellidoPaterno }} {{ deudor.apellidoMaterno }}</div>

                    <div class="p-2 text-gray-900 dark:text-gray-100" v-if="deudor.monto_pagado == deudor.monto_a_pagar">
                        <p>Pago completado.</p>
                    </div>
                    <!-- Muestra la cantidad restante cuando no se haya completado el pago -->
                    <div class="p-2 text-gray-900 dark:text-gray-100" v-else>
                        <p>Deuda en proceso</p>
                    </div>

                    <div class="p-2 text-gray-900 dark:text-gray-100" :key="id">Monto a pagar: ${{ deudor.monto_a_pagar }}</div>
                    <div class="p-2 text-gray-900 dark:text-gray-100" :key="id">Deuda desde: {{ deudor.created_at }}</div>

                    <a @click="redirectToComment(deudor.id)" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                        Ver Comentarios
                    </a>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>