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

    <Head>
      <title>
        Personas | Persuación
      </title>
    </Head>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">Sección de Personas</h2>
        </template>

        <div class="mx-auto px-10 py-5 sm:px-6 lg:max-w-7xl lg:px-8">
          <div class="grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
            <a v-for="(user, id) in item" class="group border-2 border-blue-950 p-5 rounded-lg duration-300 hover:scale-105 hover:shadow-xl bg-white">
              <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-lg xl:aspect-h-8 xl:aspect-w-7">
                <center><img src="https://icons.veryicon.com/png/o/miscellaneous/two-color-icon-library/user-286.png" width="100" /></center>
              </div>

              <h1 class="mt-4 text-lg text-black text-center" :key="id">{{ user.nombre }} {{ user.apellidoPaterno }} {{ user.apellidoMaterno }}</h1>
              <br>
              <center>
                <a @click="redirectToPost(user.id)" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
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