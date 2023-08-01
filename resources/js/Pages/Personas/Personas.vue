<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { User } from '@/types';
import { Head } from '@inertiajs/vue3';
import axios from 'axios';
import { ref, onMounted} from 'vue';
import { library } from '@fortawesome/fontawesome-svg-core';
import {faAddressCard} from '@fortawesome/free-regular-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
library.add(faAddressCard);

// Establecemos el límite máximo de noticias a mostrar
const maxPostsToShow = 50;

//Esto es para extraer los datos de deudores
const item = ref<User[]>([]);

onMounted(async () => {
  try {
    const response = await axios.get('/personas/show');
    item.value = response.data.slice(0, maxPostsToShow);
  } catch (error) {
    console.error(error);
  }
});

//Esto es para mandar la URL de cada usuario a su perfil
const redirectToPost = (id: number) => {
  window.location.href = `/personas/show/user/${id}`;
};
</script>

<style>
.profile-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

/* Template del nombre del usuario */
.profile-image-containers {
  width: 100%; 
  height: 100%; 
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
        Personas | Persuación
      </title>
    </Head>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-white leading-tight text-center">Sección de Personas</h2>
        </template>

        <div class="mx-auto px-10 py-5 sm:px-6 lg:max-w-7xl lg:px-8">
          <div class="grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
            <a v-for="(user, id) in item" class="group border-2 border-blue-950 p-5 rounded-lg duration-300 hover:scale-105 hover:shadow-xl bg-white" id="card">
              <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-lg xl:aspect-h-8 xl:aspect-w-7">
                <center>
                  <div class="profile-image-containers">
                    <img :src="user?.profile_image" class="profile-image" />
                  </div>
                </center>
              </div>

              <h1 class="mt-4 text-lg text-black text-center" :key="id">{{ user.nombre }} {{ user.apellidoPaterno }} {{ user.apellidoMaterno }}</h1>
              <br>
              <center>
                <a @click="redirectToPost(user.id)" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                  <button class="bg-white text-black font-bold rounded border-b-2 border-gray-400 hover:border-black hover:bg-gray-400 hover:text-white shadow-md py-2 px-6 inline-flex items-center">
                    <span class="mr-2">Ver Perfil</span>
                    <font-awesome-icon icon="fa-regular fa-address-card" />
                  </button>
                </a>
              </center>
            </a>
          </div>
        </div>
    </AuthenticatedLayout>
</template>