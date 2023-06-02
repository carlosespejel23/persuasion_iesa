<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Comentarios, Noticia } from '@/types';
import { Head, usePage, useForm } from '@inertiajs/vue3';
import axios from 'axios';
import { ref, onMounted, Ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';

//----Esto es para lo de la extracion de la noticia (que tienes que arreglar)
const item: Ref<Noticia | null> = ref(null);
//const route = useRoute();
//const noticiaId = route.params.id;

const router = useRouter();
const noticiaId = router.currentRoute.value.params.id;

onMounted(async () => {
  try {
    const response = await axios.get(`/dashboard/show/${noticiaId}`);
    item.value = response.data;
  } catch (error) {
    console.error(error);
  }
});
//----Esto es para lo de la extracion de la noticia

//----Esto es para crear los comentarios
const user = usePage().props.auth.user;

const form = useForm({
    usuarios_id: user.id,
    posts_id: noticiaId, //este es lo que debe recibir por la linea 15, ahora no sirve por lo que hay que arreglar
    contenido: '',
});

const submit = () => {
    form.post(route('dashboard.saveComment'), {
        onFinish: () => form.reset('contenido'),
    });
};
//----Esto es para crear los comentarios

//----Esto es para iterar los comentarios
const comentario = ref<Comentarios[]>([]);

onMounted(async () => {
  try {
    const response = await axios.get(`/dashboard/show/${noticiaId}`); //Tiene el mismo fallo que en la linea 19, forma parte del bug
    item.value = response.data;
  } catch (error) {
    console.error(error);
  }
});
//----Esto es para iterar los comentarios
</script>

<!--Aqui esta una noticia y sus comentarios-->
<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Comentarios</h2>
        </template>

        <!--Aqui va el componente de la noticia, nomas los acomodas en una tarjeta-->
        <div class="py-3">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <!--Aqui se hace un IF, si el usuario seleccionó que el post sea anónimo reemplazas el nombre por "anónimo"-->
                    <div class="p-2 text-gray-900 dark:text-gray-100">{{ item?.nombre }} {{ item?.apellidoPaterno }} {{ item?.apellidoMaterno }}</div>
                    <!--Aqui termina el IF-->

                    <!--Aqui solo das formato a la fecha-->
                    <div class="p-2 text-gray-900 dark:text-gray-100">{{ item?.created_at }}</div>
                    <div class="p-2 text-gray-900 dark:text-gray-100">{{ item?.contenido }}</div>
                </div>
            </div>
        </div>

        <!--Este es el form para crear un comentario-->
        <form @submit.prevent="submit">
            <div>
                <InputLabel for="contenido" value="Contenido" />

                <TextInput
                    id="contenido"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.contenido"
                    required
                    autofocus
                    autocomplete="contenido"
                />

                <InputError class="mt-2" :message="form.errors.contenido" />
            </div>

            <!--Este hidden para mandar el usuario autenticado y el id de la noticia-->
            <input type="hidden" v-model="form.usuarios_id"/>
            <input type="hidden" v-model="form.posts_id"/>

            <div class="flex items-center justify-end mt-4">
                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Publicar Comentarios
                </PrimaryButton>
            </div>
        </form>
        <!--Este es el form para crear un comentario-->

        <!--Aqui van los comentarios, nomas los acomodas le das diseño-->
        <div class="py-3" v-for="(comentarios, id) in comentario">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-2 text-gray-900 dark:text-gray-100" :key="id">{{ comentarios.nombre }} {{ comentarios.apellidoPaterno }} {{ comentarios.apellidoMaterno }} respondió a {{ item?.nombre }} {{ item?.apellidoPaterno }} {{ item?.apellidoMaterno }}</div>

                    <!--Aqui solo das formato a la fecha-->
                    <div class="p-2 text-gray-900 dark:text-gray-100" :key="id">{{ comentarios.created_at }}</div>
                    <div class="p-2 text-gray-900 dark:text-gray-100" :key="id">{{ comentarios.contenido }}</div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>