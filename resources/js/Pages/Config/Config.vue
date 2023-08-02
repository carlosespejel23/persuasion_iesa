<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { EmojiConfig } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import axios from 'axios';
import { ref, onMounted, defineProps, computed } from 'vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { usePage } from '@inertiajs/vue3';
import { library } from '@fortawesome/fontawesome-svg-core';
import {faThumbsUp, faShare} from '@fortawesome/free-solid-svg-icons';
import {faCircleCheck} from '@fortawesome/free-regular-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
library.add(faThumbsUp, faCircleCheck, faShare);

//Actualiza el nombre de los emojis
const page = usePage();
const emoji = ref<EmojiConfig | null>(page.props.emoji_config as EmojiConfig || null);

const form = useForm({
    like: emoji.value ? emoji.value.like : '', // Asigna una cadena vacía como valor predeterminado en lugar de null
    enojo: emoji.value ? emoji.value.enojo : '',
    comentar: emoji.value ? emoji.value.comentar : '',
    compartir: emoji.value ? emoji.value.compartir : '',
});

const submit = () => {
    form.patch(route('configuracion.update', { id: emoji.value.id }));
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
            Configuración | Persuasión
        </title>
        <link rel="icon" href="/images/icono.png" type="image/x-icon">
    </Head>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-white leading-tight text-center">
                Sección de Configuración
            </h2>
        </template>

        <!-- component -->
        <form @submit.prevent="submit">
            <div class="flex py-8 flex-col items-center justify-center space-y-6 bg-gray-100 px-6 sm:flex-row sm:space-x-6 sm:space-y-0">

                <div class="w-full max-w-sm py-8 overflow-hidden border-2 rounded-lg bg-white shadow-md duration-300 hover:scale-105 hover:shadow-xl" id="card">

                    <center>
                       <img src="/images/like_reacted.png" width="100" /> 
                    </center>

                    <div class="space-x-4 p-6 bg-white py-4 text-center">
                        <TextInput
                            id="like"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.like"
                            :value="form.like"
                            required
                            autofocus
                            autocomplete="like"
                        />

                        <InputError class="mt-2" :message="form.errors.like" />
                    </div>

                </div>

                <div class="w-full max-w-sm py-8 overflow-hidden border-2 rounded-lg bg-white shadow-md duration-300 hover:scale-105 hover:shadow-xl" id="card">

                    <center>
                        <img src="/images/dislike_reacted.png" width="85"/>
                    </center>

                    <div class="space-x-4 p-6 bg-white py-4 text-center">
                        <TextInput
                            id="enojo"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.enojo"
                            :value="form.enojo"
                            required
                            autofocus
                            autocomplete="enojo"
                        />

                        <InputError class="mt-2" :message="form.errors.enojo" />
                    </div>

                </div>

                <div class="w-full max-w-sm py-8 overflow-hidden border-2 rounded-lg bg-white shadow-md duration-300 hover:scale-105 hover:shadow-xl" id="card">

                    <center>
                        <img src="/images/comentarios.png" width="100"/>
                    </center>

                    <div class="space-x-4 p-6 bg-white py-4 text-center">
                        <TextInput
                            id="comentar"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.comentar"
                            :value="form.comentar"
                            required
                            autofocus
                            autocomplete="comentar"
                        />

                        <InputError class="mt-2" :message="form.errors.comentar" />
                    </div>

                </div>

                <div class="w-full max-w-sm py-8 overflow-hidden border-2 rounded-lg bg-white shadow-md duration-300 hover:scale-105 hover:shadow-xl" id="card">

                    <center>
                        <font-awesome-icon :icon="['fas', 'share']" size="5x"/>
                    </center>

                    <div class="space-x-4 p-6 bg-white py-4 text-center">
                        <TextInput
                            id="compartir"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.compartir"
                            :value="form.compartir"
                            required
                            autofocus
                            autocomplete="compartir"
                        />

                        <InputError class="mt-2" :message="form.errors.compartir" />
                    </div>

                </div>

            </div>

            <div class="flex items-center gap-4 justify-center mt-4">
                <PrimaryButton :disabled="form.processing" class="bg-blue-950">Actualizar Cambios</PrimaryButton>
                <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
                    <p v-if="form.recentlySuccessful" class="text-sm text-green-500">Cambios Guardados <font-awesome-icon icon="fa-regular fa-circle-check" /></p>
                </Transition>
            </div>
            <br>
        </form>
    </AuthenticatedLayout>
</template>