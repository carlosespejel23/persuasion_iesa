<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Deudor, User } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import ButtonNav from '@/components/ButtonNav.vue';
import axios from 'axios';
import { ref, onMounted, computed } from 'vue';
import { Dropdown, ListGroup, ListGroupItem } from 'flowbite-vue';
import { usePage } from '@inertiajs/vue3';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faEllipsis, faComments} from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
library.add(faEllipsis, faComments);

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
</style>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
      <div class="h-screen bg-white pt-10">
        <div class="mx-auto max-w-5xl justify-center px-6 md:flex md:space-x-6 xl:px-0">

          <!--Apartado de la foto de perfil-->
          <div class="mt-6 mb-6 h-full rounded-lg border bg-white p-6 shadow-md md:mt-0 md:w-1/3">
            <dropdown class="inline-flex items-center text-sm font-medium text-center text-gray-900 bg-white rounded-lg focus:ring-4 focus:outline-none focus:ring-gray-50">
              <template #trigger>
                <span><font-awesome-icon icon="fa-solid fa-ellipsis" size="2x" /></span>
              </template>
              <list-group>
                <list-group-item>
                  <a @click="redirectToDeudas(user.id)" class="text-sm text-gray-600 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Deudas
                  </a>
                </list-group-item>
                <list-group-item>
                  <a @click="redirectToPerfil(user.id)" class="text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Publicaciones
                  </a>
                </list-group-item>
              </list-group>
            </dropdown>
            <div class="profile-image-containers">
              <center><img :src="user?.profile_image" class="profile-image" /></center>
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
            <h1 class="font-semibold text-xl text-black leading-tight">Deudas</h1>
            <hr>
            <div v-if="deudas.length === 0">
              <h1 class="mt-4 text-lg text-gray-700 text-center">Este usuario aún no tiene deudores y pagos :(</h1>
            </div>
            <!--Aqui va el componente de la deuda, nomas los acomodas-->
            <div class="grid grid-cols-1 gap-x-2 gap-y-2 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-2 xl:gap-x-8">
            <div class="py-2" v-for="(deudor, id) in deudas">
                <div class="max-w-7xl mx-auto sm:px-4 lg:px-6">
                    <div class="bg-white border p-2 shadow-sm sm:rounded-lg">

                      <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-lg xl:aspect-h-8 xl:aspect-w-7">
                          <center><img src="https://persuacion.000webhostapp.com/deuda.png" width="150" /></center>
                      </div>
                        <!--Esta es la informacion del deudor-->
                        <div class="p-2 text-gray-900 text-center" :key="id">{{ deudor.nombre }} {{ deudor.apellidoPaterno }} {{ deudor.apellidoMaterno }}</div>

                        <div class="text-gray-900 text-center" :key="id">Deuda desde: {{ deudor.created_at }}</div>
                        <div class="text-gray-900 text-center" :key="id">Monto a pagar: ${{ deudor.monto_a_pagar }}</div>

                        <div class="text-green-500 text-center" v-if="deudor.monto_pagado == deudor.monto_a_pagar">
                            <p>Pago completado.</p>
                        </div>
                        <!-- Muestra la cantidad restante cuando no se haya completado el pago -->
                        <div class="text-red-500 text-center" v-else>
                            <p>Deuda en proceso</p>
                        </div>
                        <hr>
                        <a @click="redirectToComment(deudor.id)" class="underline text-xm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                          <div align="center">
                            <ButtonNav class="text-sm">
                              Ver Comentarios&nbsp<font-awesome-icon icon="fa-solid fa-comments" />
                            </ButtonNav>
                        </div>
                        </a>

                    </div>
                </div>
            </div>
            </div>
          </div>


        </div>
      </div>
    </AuthenticatedLayout>
</template>