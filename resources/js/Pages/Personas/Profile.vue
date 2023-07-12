<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Noticia, User } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import axios from 'axios';
import { ref, onMounted, defineProps } from 'vue';
import { usePage } from '@inertiajs/vue3';
import ReactionsComponent from '@/components/ReactionsComponent.vue';

//Esto es para extraer las noticias
const noticias = ref<Noticia[]>([]);
const uri = new URL(window.location.href);
const id = uri.pathname.split('/').pop();

onMounted(async () => {
  try {
    const response = await axios.get(`/personas/showPost/${id}`);
    noticias.value = response.data;
  } catch (error) {
    console.error(error);
  }
});

//Esto es para mandar la URL de cada noticia a los comentarios
const redirectToPost = (id: number) => {
  window.location.href = `/personas/createComment/${id}`;
};

//Esto es para mandar la URL de cada usuario a las deudas
const redirectToDeudas = (id: number) => {
  window.location.href = `/personas/show/deudas/${id}`;
};

//Esto es para mandar la URL de cada usuario a su perfil principal
const redirectToPerfil = (id: number) => {
  window.location.href = `/personas/show/user/${id}`;
};

const page = usePage();
const user = ref<User | null>(page.props.user as User || null);
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

        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-center">Publicaciones</h2>

        <!--Aqui va el componente de la noticia, nomas los acomodas en una tarjeta-->
        <div class="py-3" v-for="(noticia, id) in noticias">
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
    </AuthenticatedLayout>
</template>