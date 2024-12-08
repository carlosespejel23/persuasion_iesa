<script setup lang="ts">
import GuestLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { ComentarioDeudaPago } from '@/types';
import axios from 'axios';
import { ref, onMounted, defineProps } from 'vue';
import { library } from '@fortawesome/fontawesome-svg-core';
import {faCommentDots} from '@fortawesome/free-regular-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
library.add(faCommentDots);

defineProps<{
    mustVerifyEmail?: Boolean;
    status?: String;
}>();

const url = new URL(window.location.href);
const deudorId = url.pathname.split('/').pop();

const user = usePage().props.auth.user;

const form = useForm({
    usuario_id: user.id,
    deudor_id: deudorId,
    comentario: '',
});

const submit = () => {
    form.post(route('pagos.save'), {
        onFinish: () => form.reset('comentario'),
    });
};

//Esto es para extraer los comentarios en los deudores
const cad = ref<ComentarioDeudaPago[]>([]);
const uri = new URL(window.location.href);
const id = uri.pathname.split('/').pop();

onMounted(async () => {
  try {
    const response = await axios.get(`/pagos/show/${id}`);
    cad.value = response.data;
  } catch (error) {
    console.error(error);
  }
});
</script>

<style scoped>
    .comentar{
        font-size: large;
    }
</style>

<template>

    <Head>
        <title>
            Comentarios | Persuasión
        </title>
        <link rel="icon" href="/images/icono.png" type="image/x-icon">
    </Head>

    <GuestLayout>

        <template #header>
            <h2 class="font-semibold text-xl text-white leading-tight text-center">
              Comentarios
            </h2>
        </template>

        <form @submit.prevent="submit">
            <div class="p-6 bg-gray-100 flex items-center justify-center">
                <div>
                    <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6 border-2">
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <h2 class="px-4 pt-3 pb-2 text-gray-800 text-lg">
                                Agregar Nuevo Comentario
                            </h2>
                            <div class="w-full md:w-full px-3 mb-2 mt-2">
                                <TextInput
                                    id="comentario"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.comentario"
                                    required
                                    autofocus
                                    autocomplete="comentario"
                                />

                                <InputError class="mt-2" :message="form.errors.comentario" />
                            </div>

                            <!--Este hidden para mandar el usuario autenticado-->
                            <input type="hidden" v-model="form.usuario_id"/>

                            <!--Este hidden para mandar el id del deudor mostrado en pantalla-->
                            <input type="hidden" v-model="form.deudor_id"/>

                            <div class="flex items-center justify-end mt-4">
                                <PrimaryButton class="ml-4 bg-blue-950" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Comentar&nbsp<font-awesome-icon icon="fa-regular fa-comment-dots" class="comentar" />
                                </PrimaryButton>
                            </div>
                        </div>

                        <h2 class="pt-3 pb-2 text-gray-800 text-lg">
                            Lista de Comentarios
                        </h2>
                        <hr>

                        <div class="py-3" v-for="(comentario, id) in cad">
                            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 border-2 rounded-md border-blue-950">
                                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                    <div class="p-2 text-black text-justify" :key="id">{{ comentario.comentario }}</div>
                                    <div class="p-2 text-black text-sm" align="right" :key="id">Fecha: {{ comentario.created_at }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </GuestLayout>
</template>