<script setup lang="ts">
import GuestLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { Comentarios } from '@/types';
import axios from 'axios';
import { ref, onMounted, defineProps } from 'vue';

defineProps<{
    mustVerifyEmail?: Boolean;
    status?: String;
}>();

const url = new URL(window.location.href);
const postsId = url.pathname.split('/').pop();

const user = usePage().props.auth.user;

const form = useForm({
    usuarios_id: user.id,
    posts_id: postsId,
    contenido: '',
});

const submit = () => {
    form.post(route('personas.saveComment'), {
        onFinish: () => form.reset('contenido'),
    });
};

//Esto es para extraer los comentarios
const comentarios = ref<Comentarios[]>([]);
const uri = new URL(window.location.href);
const noticia = uri.pathname.split('/').pop();

onMounted(async () => {
  try {
    const response = await axios.get(`/personas/showComment/${noticia}`);
    comentarios.value = response.data;
  } catch (error) {
    console.error(error);
  }
});
</script>

<template>
    <GuestLayout>
        <Head title="Comentarios" />

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="contenido" value="Comentario" />

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

            <!--Este hidden para mandar el usuario autenticado-->
            <input type="hidden" v-model="form.usuarios_id"/>

            <!--Este hidden para mandar el id del deudor mostrado en pantalla-->
            <input type="hidden" v-model="form.posts_id"/>

            <div class="flex items-center justify-end mt-4">
                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Agregar Comentario
                </PrimaryButton>
            </div>
        </form>

        <div class="py-3" v-for="(comentario, id) in comentarios">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-2 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100" :key="id">{{ comentario.nombre }} {{ comentario.apellidoPaterno }} {{ comentario.apellidoMaterno }}   {{ comentario.created_at }}</div>
                    <div class="p-2 text-gray-900 dark:text-gray-100" :key="id">{{ comentario.contenido }}</div>
                </div>
            </div>
        </div>

    </GuestLayout>
</template>