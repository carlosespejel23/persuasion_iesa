<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import TextEmail from '@/components/TextEmail.vue';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faKey, faCircleArrowLeft, faPhone, faLocationDot } from '@fortawesome/free-solid-svg-icons';
import {faFacebook, faTwitter, faYoutube} from '@fortawesome/free-brands-svg-icons';
import {faEnvelope} from '@fortawesome/free-regular-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
library.add(faKey, faCircleArrowLeft, faFacebook, faTwitter, faYoutube, faPhone, faLocationDot, faEnvelope);

defineProps<{
    status?: string;
}>();

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>

    <Head>
        <title>
            Recuperar Contraseña | Persuasión
        </title>
    </Head>

    <!--Barra de navegacion-->
    <nav class="bg-blue-950 px-6 relative shadow-md">
        <div class="flex flex-row justify-between items-center py-2">
            <Link href="/"><img src="/images/logob.png" width="100" /></Link>
        </div>
    </nav>  

    <div class="max-w-lg mx-auto my-10 bg-white p-10 rounded-xl border-2">

        <h1 class="text-4xl font-medium text-center text-black">Recuperar Contraseña</h1>
        <br>
        <p class="text-center text-black">
            Ingresa el correo electrónico para recuperar tu cuenta, al recibir el enlace en tu correo sigue los pasos para restablecerla.
        </p>
        <form @submit.prevent="submit">

            <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                {{ status }}
            </div>

            <div class="flex flex-col space-y-5">

                <div>
                    <TextEmail
                        id="email"
                        type="email"
                        class="mt-1 block w-full"
                        v-model="form.email"
                        required
                        autofocus
                        autocomplete="username"
                    />

                    <InputError class="mt-2" :message="form.errors.email" />
                </div>
               
                <div class="flex items-center justify-end mt-4">
                    <PrimaryButton class="bg-blue-950" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        <font-awesome-icon icon="key" /> &nbspRecuperar
                    </PrimaryButton>
                </div>

                <hr>

                <div class="text-center">
                    <p align="center" style="font-size: small;">¿No tienes Cuenta? 
                        <Link
                            :href="route('register')"
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                        Registrate</Link>
                    </p>
				</div>
            </div>
        </form>
    </div>

    <!-- Footer -->
    <footer class="bg-blue-950">

        <div class="container px-6 py-12 mx-auto">

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 sm:gap-y-10 lg:grid-cols-4">
                <div class="sm:col-span-12">
                    <center><h1 class="max-w-lg text-xl font-semibold tracking-tight text-white xl:text-2xl">Libertad de Expresión y Seguridad Financiera</h1></center>

                    <div class="flex flex-col mx-auto mt-6 space-y-3 md:space-y-0 md:flex-row">
                        <p class="text-center text-white">
                            Esta empresa se dedica a brindar un servicio de préstamos a un conjunto de personas que lo solicite, y a su vez
                            existe una comunidad virtual donde las personas pueden compartir alguna noticia o hacer un comentario donde podran 
                            interactuar con reacciones.
                        </p>
                    </div>
                </div>
            </div>

            <hr class="my-6 border-gray-100 md:my-8">

            <div class="flex items-center justify-between">
                <Link href="/">
                    <img class="w-auto h-7" src="/images/logob.png" alt="">
                </Link>
                
                <div class="flex -mx-2">
                    <p class="text-white text-sm">
                        © Todos los Derechos Reservados | Persuación
                    </p>
                </div>
            </div>
        </div>
    </footer>
</template>
