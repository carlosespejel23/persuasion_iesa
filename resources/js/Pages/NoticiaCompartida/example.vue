<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { ref, onMounted, defineProps } from 'vue';
import { Noticia, Comentarios } from '@/types';
import axios from 'axios';

defineProps<{
    canLogin?: boolean;
    canRegister?: boolean;
}>();

//Esto es para extraer las noticias
const item = ref<Noticia[]>([]);
const uri = new URL(window.location.href);
const slug = uri.pathname.split('/').pop();

onMounted(async () => {
  try {
    const response = await axios.get(`/noticia/cj-json-post/share/${slug}`);
    item.value = response.data;
  } catch (error) {
    console.error(error);
  }
});

//Esto es para extraer los comentarios
const comentarios = ref<Comentarios[]>([]);

onMounted(async () => {
  try {
    const response = await axios.get(`/noticia/cj-json-post-comment/share/${slug}`);
    comentarios.value = response.data;
  } catch (error) {
    console.error(error);
  }
});

//Compartir la noticia
const shareOnWhatsApp = () => {
  const appUrl = 'http://127.0.0.1:8000/noticia/'; // Ajusta la URL base según tu aplicación
  const noticia = item.value[0]; // Supongamos que obtienes una sola noticia

  const shareUrl = appUrl + encodeURIComponent(noticia.slug);

  // Enlace de redireccionamiento que incluye la URL completa de la noticia
  const redirectUrl = `http://127.0.0.1:8000/noticia/${encodeURIComponent(noticia.slug)}`;
  //const redirectUrl = `http://your-website.com/noticia/${encodeURIComponent(noticia.slug)}`;

  if (navigator.share) {
    navigator.share({
      title: 'Noticia de Persuasion Financial',
      url: redirectUrl,
    })
      .then(() => {
        console.log('Contenido compartido con éxito');
      })
      .catch((error) => {
        console.error('Error al compartir contenido:', error);
      });
  } else {
    console.log('La API de compartir no es compatible');
    // Aquí puedes proporcionar una alternativa para dispositivos que no admitan la API de compartir
  }
};

</script>

<!--Aqui añades una ventana modal para que invite a iniciar sesion o registrarse-->

<template>
    <Head title="Welcome" />
    <div  class="sm:fixed sm:top-0 sm:right-0 p-6 text-right">
            <Link
                v-if="$page.props.auth.user"
                :href="route('dashboard')"
                class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                >Panel Principal</Link
            >

            <template v-else>
                <Link
                    :href="route('login')"
                    class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                    >Log in</Link
                >

                <Link
                    :href="route('register')"
                    class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                    >Register</Link
                >
            </template>
        </div>
    <div>

        <div class="min-h-screen bg-gray-100 dark:bg-gray-900"><br><br>

            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-center">Publicacion</h2>

            <!-- Page Content -->
            <main>
                <slot />
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

                            <button @click="shareOnWhatsApp()">Compartir</button>

                        </div>
                    </div>
                </div><br><br>

                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-center">Comentarios</h2>

                <div class="py-3" v-for="(comentario, id) in comentarios">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-2 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100" :key="id">{{ comentario.nombre }} {{ comentario.apellidoPaterno }} {{ comentario.apellidoMaterno }}   {{ comentario.created_at }}</div>
                            <div class="p-2 text-gray-900 dark:text-gray-100" :key="id">{{ comentario.contenido }}</div>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>
</template>