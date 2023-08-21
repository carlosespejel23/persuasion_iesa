<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Noticia, User } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import axios from 'axios';
import { ref, onMounted, defineProps } from 'vue';
import { usePage } from '@inertiajs/vue3';
//import { Dropdown, ListGroup, ListGroupItem } from 'flowbite-vue';
import Dropdown from '@/components/Dropdown.vue';
import DropdownLink from '@/components/DropdownLink.vue';
import ReactionsComponent from '@/components/ReactionsComponent.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { format, differenceInSeconds, differenceInMinutes, differenceInHours, differenceInDays } from 'date-fns';
//Importacion de iconos
import { library } from '@fortawesome/fontawesome-svg-core';
import {faNewspaper, faEnvelope} from '@fortawesome/free-regular-svg-icons';
import {faFacebook, faTelegram, faTwitter, faWhatsapp} from '@fortawesome/free-brands-svg-icons';
import { faShare, faPhone, faEllipsisVertical} from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
library.add(faNewspaper, faFacebook, faTwitter, faWhatsapp, faTelegram, faEnvelope, faShare, faPhone, faEllipsisVertical);

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
.div-container {
  max-width: 280px;
  height: 280px; /* Puedes ajustar la altura según tus necesidades */
}

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
  width: 280px; 
  height: 280px; 
  border-radius: 50%;
  overflow: hidden;
}

#card{
  border-color: #0065b5;
}
</style>

<template>

    <Head>
      <title>
        Perfil | Persuasión
      </title>
      <link rel="icon" href="/images/icono.png" type="image/x-icon">
    </Head>

    <AuthenticatedLayout>
      <div class="h-screen bg-white pt-10">
        <div class="mx-auto max-w-5xl justify-center px-6 md:flex md:space-x-6 xl:px-0">

          <!--Apartado de la foto de perfil-->
          <div class="mt-6 mb-6 h-full rounded-lg border bg-white p-6 shadow-md md:mt-0 md:w-1/3">
            <Dropdown>
              <template #trigger>
                <div align="right"><span><font-awesome-icon icon="fa-solid fa-ellipsis-vertical" size="2x" /></span></div>
              </template>
              <template #content>
                <DropdownLink @click="redirectToPerfil(user.id)">
                  <a class="text-sm text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Publicaciones
                  </a>
                </DropdownLink>
                <DropdownLink  @click="redirectToDeudas(user.id)">
                  <a class="text-sm text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Deudas
                  </a>
                </DropdownLink>
              </template>
            </Dropdown>
            <div class="div-container">
              <div class="profile-image-containers">
                <center><img :src="user?.profile_image" class="profile-image" /></center>
              </div>
            </div>
            <h1 class="font-semibold py-2 text-3xl text-center text-black leading-tight">{{ user?.nombre }} {{ user?.apellidoPaterno }} {{ user?.apellidoMaterno }}</h1>
            <hr>
            <br>
            <div class="py-2 rounded-lg bg-gray-100">
              <h2 class="font-semibold py-2 p-3 text-black leading-tight">Información</h2>
              <h2 class="font-semibold py-2 p-6 text-black leading-tight" :key="id">Correo Electrónico:  {{ user?.email }}</h2>
              <h2 class="font-semibold py-2 p-6 text-black leading-tight" :key="id">Teléfono:  {{ user?.telefono }}</h2>
              <h2 class="font-semibold py-2 p-6 text-black leading-tight" :key="id">Se Unio:  {{ user?.created_at }}</h2>
            </div>
          </div>

          <!--Apartado de las noticias-->
          <div class="rounded-lg md:w-2/3">

            <h1 class="font-semibold text-xl text-black leading-tight">Publicaciones</h1>
            <hr>

            <div v-if="noticias.length === 0">
              <h1 class="mt-4 text-lg text-gray-700 text-center">Este usuario aún no tiene publicaciones :(</h1>
            </div>
        
            <!--Componente de la noticia-->
            <div class="py-3" v-for="(noticia, id) in noticias" :key="id">
                <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden border shadow-sm sm:rounded-lg flex" id="card"> <!-- Agregamos la clase flex aquí -->

                        <!-- Espacio reservado para la fotografía de perfil -->
                        <div class="p-2">
                            <div class="profile-image-container">
                                <img :src="noticia.profile_image" width="50" />
                            </div>
                        </div>

                        <div class="flex-1"> <!-- Utilizamos flex-1 para que el contenido ocupe todo el espacio restante -->
                            <div class="flex items-center"> <!-- Utilizamos flex para alinear el nombre y la fecha horizontalmente -->
                                <div class="p-2 text-gray-900 font-semibold"> {{ noticia.nombre }} {{ noticia.apellidoPaterno }} {{ noticia.apellidoMaterno }} &nbsp;&nbsp;·</div>
                                <div class="text-sm text-gray-600 ml-1">{{ formatTimeSincePublished(noticia.created_at) }}</div>
                                <div v-if="noticia.created_at !== noticia.updated_at">
                                  <div class="text-sm text-gray-600 ml-1">&nbsp;&nbsp;·&nbsp;&nbsp;editado</div>
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
                    <h2 class="text-lg font-medium text-black">
                        Compartir Noticia
                    </h2>
                    <p class="mt-1 text-sm text-black">
                        Selecciona una red social para compartir la noticia.

                        <!-- Botones de compartir -->
                        <div class="p-2 text-gray-900">
                            <div class="flex items-center justify-center">
                            <a :href="getFacebookShareLink(noticia)"><font-awesome-icon :icon="['fab', 'facebook']" size="4x" class="p-4 hover:text-blue-800" /></a>
                            <a :href="getTwitterShareLink(noticia)"><font-awesome-icon :icon="['fab', 'twitter']" size="4x" class="p-4 hover:text-blue-400" /></a>
                            <a :href="getWhatsAppShareLink(noticia)"><font-awesome-icon :icon="['fab', 'whatsapp']" size="4x" class="p-4 hover:text-green-500" /></a>
                            <a :href="getGmailLink(noticia)"><font-awesome-icon :icon="['far', 'envelope']" size="4x" class="p-4 hover:text-red-500" /></a>
                            <a :href="getTelegramLink(noticia)"><font-awesome-icon :icon="['fab', 'telegram']" size="4x" class="p-4 hover:text-blue-300" /></a>
                            </div>
                        </div>
                    </p>
                    <div class="mt-3 flex justify-end">
                        <SecondaryButton @click="closeModal">Cancelar</SecondaryButton>
                    </div>
                    </div>
                </Modal>
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
</template>