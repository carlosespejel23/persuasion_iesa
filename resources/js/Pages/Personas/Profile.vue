<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Noticia, User } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import axios from 'axios';
import { ref, onMounted, defineProps } from 'vue';
import { usePage } from '@inertiajs/vue3';
import ReactionsComponent from '@/components/ReactionsComponent.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { format, differenceInSeconds, differenceInMinutes, differenceInHours, differenceInDays } from 'date-fns';
//Importacion de iconos
import { library } from '@fortawesome/fontawesome-svg-core';
import {faNewspaper, faEnvelope} from '@fortawesome/free-regular-svg-icons';
import {faFacebook, faTelegram, faTwitter, faWhatsapp} from '@fortawesome/free-brands-svg-icons';
import { faShare } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
library.add(faNewspaper, faFacebook, faTwitter, faWhatsapp, faTelegram, faEnvelope, faShare);

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

/* Template del nombre del usuario */
.profile-image-containers {
  width: 60px; 
  height: 60px; 
  border-radius: 50%;
  overflow: hidden;
}
</style>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
          <div class="flex items-center">
            <div class="profile-image-containers">
              <img :src="user?.profile_image" class="profile-image" />
            </div>&nbsp;&nbsp;&nbsp;
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ user?.nombre }} {{ user?.apellidoPaterno }} {{ user?.apellidoMaterno }}</h2>
          </div>
        </template>

        <!--Aqui va la info del usuario-->
        <div class="py-3">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-2 text-gray-900" :key="id">INFORMACION</div>
                    <div class="p-2 text-gray-900" :key="id">Correo Electronico: {{ user?.email }}</div>
                    <div class="p-2 text-gray-900" :key="id">Telefono: {{ user?.telefono }}</div>
                    <div class="p-2 text-gray-900" :key="id">Se unio: {{ user?.created_at }}</div>
                </div>
            </div>
        </div>

        <!--Si quieres aqui haces un mini menu-->
        <a @click="redirectToDeudas(user.id)" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Sección Deudas
        </a><br>
        <a @click="redirectToPerfil(user.id)" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Publicaciones
        </a>

        <hr>
        <br>

        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">Publicaciones</h2><br>

        <div v-if="noticias.length === 0">
          <h1 class="mt-4 text-lg text-gray-700 text-center">Este usuario aún no tiene publicaciones :(</h1>
        </div>
        <!--Componente de la noticia-->
        <div class="py-3" v-for="(noticia, id) in noticias" :key="id">
                <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex"> <!-- Agregamos la clase flex aquí -->

                        <!-- Espacio reservado para la fotografía de perfil -->
                        <div class="p-2">
                            <div class="profile-image-container">
                                <img :src="noticia.profile_image" class="profile-image" />
                            </div>
                        </div>

                        <div class="flex-1"> <!-- Utilizamos flex-1 para que el contenido ocupe todo el espacio restante -->
                            <div class="flex items-center"> <!-- Utilizamos flex para alinear el nombre y la fecha horizontalmente -->
                                <div class="p-2 text-gray-900 font-semibold"> {{ noticia.nombre }} {{ noticia.apellidoPaterno }} {{ noticia.apellidoMaterno }} &nbsp;&nbsp;·</div>
                                <div class="text-sm text-gray-600 ml-1">{{ formatTimeSincePublished(noticia.created_at) }}</div>
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

            </div>

    </AuthenticatedLayout>
</template>