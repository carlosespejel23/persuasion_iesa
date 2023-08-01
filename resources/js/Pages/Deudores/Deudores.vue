<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Deudor } from '@/types';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import axios from 'axios';
import { ref, onMounted, defineProps } from 'vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { library } from '@fortawesome/fontawesome-svg-core';
import {faUserPlus, faTrash} from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
library.add(faUserPlus, faTrash);

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

//Esto es para eliminar un deudor
const deudor = usePage().props.auth.deudor;

//Formulario de Datos
const form = useForm({
    id: '',
});

// Estado de la ventana modal
const showModalUploaded = ref(false);

// Función para manejar el clic en el botón de eliminar
const handleSaveClick = () => {
    showModalUploaded.value = true;
};

const closeModalUploaded = () => {
  showModalUploaded.value = false;
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
            Deudores | Persuación
        </title>
    </Head>

    <AuthenticatedLayout>
        
        <template #header>
            <h1 class="font-semibold text-xl text-white leading-tight mx-auto text-center">
                Sección de Deudores
            </h1>
        </template>

        <!--Aqui va el componente de la noticia, nomas los acomodas en una tarjeta-->
        <div class="mx-auto px-10 py-5 sm:px-6 lg:max-w-7xl lg:px-8 bg-gray-100">

            <div class="mb-5">
                <Link :href="route('deudores.create')">
                    <button class="bg-white text-gray-800 font-bold rounded border-b-2 border-blue-950 hover:border-blue-950 hover:bg-blue-950 hover:text-white shadow-md py-2 px-6 inline-flex items-center">
                        <span class="mr-2">Agregar Deudor</span>
                        <font-awesome-icon icon="user-plus" />
                    </button>
                </Link>
            </div>

            <div v-if="item.length === 0"><br><br>
                    <h1 class="mt-4 text-lg text-gray-700 text-center">Ups, aún no tienes deudores :(</h1>
            </div>

            <div v-else>
                <div class="grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
                    <a v-for="(deudor, id) in item" class="group border-2 p-5 rounded-lg duration-300 hover:scale-105 hover:shadow-xl bg-white" id="card">
                        <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-lg xl:aspect-h-8 xl:aspect-w-7">
                            <center><img src="https://persuacion.000webhostapp.com/deu.png" width="150" /></center>
                        </div>
                        <h1 class="mt-4 text-lg text-black text-center" :key="id">{{ deudor.nombre }} {{ deudor.apellidoPaterno }} {{ deudor.apellidoMaterno }}</h1>
                        <br>
                        <center>
                            <form @submit.prevent="form.delete(route('deudores.destroy', deudor.id))">
                                <button :disabled="form.processing" @click="handleSaveClick" style="cursor: pointer;" class="bg-white text-gray-800 font-bold rounded border-b-2 border-red-400 hover:border-red-950 hover:bg-red-400 hover:text-white shadow-md py-2 px-6 inline-flex items-center">
                                    <span class="mr-2">Eliminar Deudor</span>
                                    <font-awesome-icon icon="fa-solid fa-trash" />
                                </button>
                            </form>

                            <!-- Ventana modal 2: Cuando ya hay una foto cargada -->
                            <Modal :show="showModalUploaded" @close="closeModalUploaded">
                                <div class="p-6">
                                    <h2 class="text-lg text-center font-medium text-gray-900">
                                    Eliminado
                                    </h2>
                                    <center><img src="https://persuacion.000webhostapp.com/eliminar.gif" width="150" /></center>
                                    <p class="mt-1 text-sm text-center text-gray-600">
                                        Has eliminado un deudor de tu lista.
                                    </p>
                                    <div class="mt-6 flex justify-end">
                                    <SecondaryButton @click="closeModalUploaded">Cerrar</SecondaryButton>
                                    </div>
                                </div>
                            </Modal>
                        </center>
                    </a>
                </div>
            </div>  
        </div>
    </AuthenticatedLayout>
</template>