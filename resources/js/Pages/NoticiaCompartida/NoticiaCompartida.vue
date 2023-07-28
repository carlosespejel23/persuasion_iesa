<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { ref, onMounted, defineProps } from 'vue';
import { Noticia, Comentarios } from '@/types';
import axios from 'axios';
import ReactionsComponent from '@/components/ReactionsComponent.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { format, differenceInSeconds, differenceInMinutes, differenceInHours, differenceInDays } from 'date-fns';
//Importacion de iconos
import { library } from '@fortawesome/fontawesome-svg-core';
import {faNewspaper, faEnvelope} from '@fortawesome/free-regular-svg-icons';
import {faFacebook, faTelegram, faTwitter, faWhatsapp} from '@fortawesome/free-brands-svg-icons';
import { faShare, faHouse, faRightToBracket, faUsers } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
library.add(faNewspaper, faFacebook, faTwitter, faWhatsapp, faTelegram, faEnvelope, faShare, faHouse, faRightToBracket, faUsers);

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

// Función para formatear la diferencia de tiempo desde que se publicó el post
const formatTimeSincePublished = (dateString: string) => {
  const currentDate = new Date();
  const postDate = new Date(dateString);
  const secondsDifference = differenceInSeconds(currentDate, postDate);

  if (secondsDifference < 60) {
    return `${secondsDifference}s`;
  } else {
    const minutesDifference = differenceInMinutes(currentDate, postDate);

    if (minutesDifference < 60) {
      return `${minutesDifference}min`;
    } else {
      const hoursDifference = differenceInHours(currentDate, postDate);

      if (hoursDifference < 24) {
        return `${hoursDifference}h`;
      } else {
        const daysDifference = differenceInDays(currentDate, postDate);
        return `${daysDifference}d`;
      }
    }
  }
};

// Ventana modal para compartir noticia
const showModal = ref(false);

const handleClick = () => {
    showModal.value = true;
};

const closeModal = () => {
  showModal.value = false;
};

// Métodos para generar los enlaces de compartir
const appUrl = 'http://127.0.0.1:8000/noticia/';

const getFacebookShareLink = (noticia: any) => {
  const facebookUrl = `https://www.facebook.com/sharer.php?u=${encodeURIComponent(appUrl + noticia.slug)}`;
  return facebookUrl;
};

const getTwitterShareLink = (noticia: any): string => {
  const tweetText = `Echa un vistazo a esta publicación en la aplicación PERSUASIÓN FINANCIAL: `;
  const twitterUrl = `https://twitter.com/intent/tweet?url=${encodeURIComponent(appUrl + noticia.slug)}&text=${encodeURIComponent(tweetText)}`;
  return twitterUrl;
};

const getWhatsAppShareLink = (noticia: any) => {
  const whatsappText = `Echa un vistazo a esta publicación en la aplicación PERSUASIÓN FINANCIAL: `;
  const whatsappUrl = `https://api.whatsapp.com/send?text=${encodeURIComponent(whatsappText)}%0A${encodeURIComponent(appUrl + noticia.slug)}`;
  return whatsappUrl;
};

const getGmailLink = (noticia: any) => {
  const subject = 'PERSUASIÓN FINANCIAL: ';
  const body = 'Echa un vistazo a esta publicación en la aplicación PERSUASIÓN FINANCIAL: ';
  const gmailUrl = `mailto:?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
  return gmailUrl;
};

const getTelegramLink = (noticia: any) => {
  const telegramText = `Echa un vistazo a esta publicación en la aplicación PERSUASIÓN FINANCIAL: `;
  const telegramUrl = `https://telegram.me/share/url?url=${encodeURIComponent(appUrl + noticia.slug)}&text=${encodeURIComponent(telegramText)}`;
  return telegramUrl;
};
</script>

<style>
.profile-image-container {
  width: 40px; /* Ajusta el tamaño según tus necesidades */
  height: 40px; /* Ajusta el tamaño según tus necesidades */
  border-radius: 50%;
  overflow: hidden;
}

.profile-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
}
</style>

<!--Aqui añades una ventana modal para que invite a iniciar sesion o registrarse-->

<template>
    <Head title="Welcome" />
    <div  class="sm:fixed sm:top-0 sm:right-0 p-6 text-right">
            <Link
                v-if="$page.props.auth.user"
                :href="route('dashboard')"
                class="font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                >Panel Principal &nbsp;<font-awesome-icon icon="house" /></Link
            >

            <template v-else>
                <Link
                    :href="route('login')"
                    class="font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                    >Iniciar sesión &nbsp;<font-awesome-icon icon="right-to-bracket" /></Link
                >

                <Link
                    :href="route('register')"
                    class="ml-4 font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                    >Registrarse &nbsp;<font-awesome-icon icon="users" /></Link
                >
            </template>
        </div>
    <div>

        <div class="min-h-screen bg-gray-100"><br><br>

            <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">Publicación</h2>

            <!-- Page Content -->
            <main>
                <slot />
                <!--Componente de la noticia-->
            <div class="py-3" v-for="(noticia, id) in item" :key="id">
                <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex"> <!-- Agregamos la clase flex aquí -->

                        <!-- Espacio reservado para la fotografía de perfil -->
                        <div class="p-2">
                            <div v-if="noticia.post_anonimo === 1">
                                <div class="profile-image-container">
                                    <img src="/images/anonimo.png" class="profile-image" />
                                </div>
                            </div>
                            <div v-else>
                                <div class="profile-image-container">
                                    <img :src="noticia.profile_image" class="profile-image" />
                                </div>
                            </div>
                        </div>

                        <div class="flex-1"> <!-- Utilizamos flex-1 para que el contenido ocupe todo el espacio restante -->
                            <div v-if="noticia.post_anonimo === 1">
                                <div class="flex items-center">
                                    <div class="p-2 text-gray-900 font-semibold">Anónimo &nbsp;&nbsp;·</div>
                                    <div class="text-sm text-gray-600 ml-1">{{ formatTimeSincePublished(noticia.created_at) }}</div>
                                </div>
                            </div>
                            <div v-else>
                                <div class="flex items-center"> <!-- Utilizamos flex para alinear el nombre y la fecha horizontalmente -->
                                    <div class="p-2 text-gray-900 font-semibold">{{ noticia.nombre }} {{ noticia.apellidoPaterno }} {{ noticia.apellidoMaterno }} &nbsp;&nbsp;·</div>
                                    <div class="text-sm text-gray-600 ml-1">{{ formatTimeSincePublished(noticia.created_at) }}</div>
                                </div>
                            </div>

                            <div class=" text-gray-900">&nbsp;&nbsp;{{ noticia.contenido }}</div>

                            <div class="p-2 flex items-center">
                                <ReactionsComponent :post-id="noticia.id"></ReactionsComponent>&nbsp;&nbsp;&nbsp;&nbsp;
                                <a @click="handleClick">
                                    <font-awesome-icon :icon="['fas', 'share']" />
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Ventana modal -->
                <Modal :show="showModal" @close="closeModal">
                    <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-900">
                        Compartir Noticia
                    </h2>
                    <p class="mt-1 text-sm text-gray-600">
                        Selecciona una red social para compartir la noticia.

                        <!-- Botones de compartir -->
                        <div class="p-2 text-gray-900">
                            <div class="flex items-center">
                            <a :href="getFacebookShareLink(noticia)"><font-awesome-icon :icon="['fab', 'facebook']" size="3x"/></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <a :href="getTwitterShareLink(noticia)"><font-awesome-icon :icon="['fab', 'twitter']" size="3x"/></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <a :href="getWhatsAppShareLink(noticia)"><font-awesome-icon :icon="['fab', 'whatsapp']" size="3x"/></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <a :href="getGmailLink(noticia)"><font-awesome-icon :icon="['fas', 'envelope']" size="3x"/></a>
                            <a :href="getTelegramLink(noticia)"><font-awesome-icon :icon="['fab', 'telegram']" size="3x"/></a>
                            </div>
                        </div>
                    </p>
                    <div class="mt-6 flex justify-end">
                        <SecondaryButton @click="closeModal">Cancelar</SecondaryButton>
                    </div>
                    </div>
                </Modal>

            </div><br><br>

                <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">Comentarios</h2>

                <div v-if="comentarios.length === 0"><br><br>
                    <h1 class="mt-4 text-lg text-gray-700 text-center">Esta publicación aun no tiene comentarios :(</h1>
                </div>
                <!--Componente de los comentarios-->
                <div class="py-3" v-for="(comentario, id) in comentarios">
                  <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex">

                          <!-- Fotografía de perfil -->
                          <div class="p-2">
                              <div class="profile-image-container">
                                  <img :src="comentario.profile_image" class="profile-image" />
                              </div>
                          </div>

                          <div class="flex-1">
                              <div class="flex items-center"> <!-- Utilizamos flex para alinear el nombre y la fecha horizontalmente -->
                                  <div class="p-2 text-gray-900 font-semibold">{{ comentario.nombre }} {{ comentario.apellidoPaterno }} {{ comentario.apellidoMaterno }} &nbsp;&nbsp;·</div>
                                  <div class="text-sm text-gray-600 ml-1">{{ formatTimeSincePublished(comentario.created_at) }}</div>
                              </div>
                              <div class=" text-gray-900">&nbsp;&nbsp;{{ comentario.contenido }}</div><br>
                          </div>
                      </div>
                  </div>
              </div>

            </main>
        </div>
    </div>
</template>