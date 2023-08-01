<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Deudor } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import axios from 'axios';
import { ref, onMounted, defineProps } from 'vue';
import { library } from '@fortawesome/fontawesome-svg-core';
import {faPenToSquare} from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
library.add(faPenToSquare);

//Esto es para extraer los datos de deudores
const item = ref<Deudor[]>([]);

onMounted(async () => {
  try {
    const response = await axios.get('/deudores/show');
    item.value = response.data;
  } catch (error) {
    console.error(error);
  }
});

//Esto es para ir a la actualizacion del pago
const redirectToPost = (id: number) => {
  window.location.href = `/pagos/${id}`;
};
</script>

<style scoped>
    #card{
        border-color: #0065b5;
    }
</style>

<template>
  
  <Head>
    <title>
      Pagos | Persuación
    </title>
  </Head>

  <AuthenticatedLayout>

    <template #header>
      <h2 class="font-semibold text-xl text-white leading-tight text-center">
        Sección de Pagos
      </h2>
    </template>

    <div v-if="item.length === 0"><br><br>
      <h1 class="mt-4 text-lg text-gray-700 text-center">Ups, aún no tienes pagos :(</h1>
    </div>

    <div v-else>
      <div class="mx-auto px-10 py-5 sm:px-6 lg:max-w-7xl lg:px-8">
        <div class="grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
          <a v-for="(deudor, id) in item" class="group border-2 border-blue-950 p-5 rounded-lg duration-300 hover:scale-105 hover:shadow-xl bg-white" id="card">
            <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-lg xl:aspect-h-8 xl:aspect-w-7">
              <center><img src="https://persuacion.000webhostapp.com/pago.png" width="150" /></center>
            </div>

            <h1 class="mt-4 text-lg text-black text-center" :key="id">{{ deudor.nombre }} {{ deudor.apellidoPaterno }} {{ deudor.apellidoMaterno }}</h1>
            <br>
            <center>
              <a @click="redirectToPost(deudor.id)" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <button class="bg-white text-gray-800 font-bold rounded border-b-2 border-green-400 hover:border-green-400 hover:bg-green-400 hover:text-white shadow-md py-2 px-6 inline-flex items-center">
                  <span class="mr-2">Actualizar Deuda</span>
                  <font-awesome-icon icon="fa-solid fa-pen-to-square" />
                </button>
              </a>
            </center>
          </a>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>