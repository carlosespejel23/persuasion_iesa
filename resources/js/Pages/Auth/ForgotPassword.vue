<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import ButtonNav from '@/components/ButtonNav.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import TextInputEmail from '@/components/TextInputEmail.vue';
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
            Recuperar Contraseña
        </title>
    </Head>

    <!--Barra de navegacion-->
    <nav class="bg-white px-6 relative shadow-md">
        <div class="flex flex-row justify-between items-center py-2">
            <Link href="/"><img src="https://persuacion.000webhostapp.com/logotipo.png" width="100" /></Link>

            <div class="group flex flex-col items-center">

                <button class="p-2 rounded-lg md:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="h-10 fill-current" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" /></svg>
                </button>

                <div class="hidden group-hover:block md:block absolute md:static bg-white inset-x-0 top-16 py-3 shadow-md md:shadow-none text-gray-600">
                    <div class="flex flex-row justify-center items-center text-center font-semibold text-gray-500">
                        <Link :href="route('login')">
                            <ButtonNav class="ml-4 bg-white" :href="route('login')">
                                <font-awesome-icon icon="circle-arrow-left" />&nbspRegresar
                            </ButtonNav>
                        </Link>
                    </div>
                </div>
            </div>

        </div>
    </nav>

    <div class="max-w-lg mx-auto my-10 bg-white p-10 rounded-xl border">

        <h1 class="text-4xl font-medium text-center text-black">Recuperar Contraseña</h1>
        <p class="text-slate-500 text-center text-black">
            Ingresa el correo electrónico para recuperar tu cuenta, al recibir el enlace en tu correo sigue los pasos para restablecerla.
        </p>
        <form @submit.prevent="submit">

            <div v-if="status" class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                {{ status }}
            </div>

            <div class="flex flex-col space-y-5">

                <div>
                    <TextInputEmail
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
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing" style="background: #0065b5;">
                        <font-awesome-icon icon="key" /> &nbspRecuperar
                    </PrimaryButton>
                </div>

                <hr>

                <div class="text-center">
                    <p align="center" style="font-size: small;">¿No tienes Cuenta? 
                        <Link
                            :href="route('register')"
                            class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                        >
                        Registrate</Link>
                    </p>
				</div>
            </div>
        </form>
    </div>

    <!-- Footer -->
    <footer class="bg-white dark:bg-gray-900 border-top">

        <div class="container px-6 py-12 mx-auto">

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 sm:gap-y-10 lg:grid-cols-4">
                <div class="sm:col-span-2">
                    <h1 class="max-w-lg text-xl font-semibold tracking-tight text-gray-800 xl:text-2xl dark:text-white">Libertad de Expresión y Seguridad Financiera</h1>

                    <div class="flex flex-col mx-auto mt-6 space-y-3 md:space-y-0 md:flex-row">
                    
                        <p class="text-justify text-black">
                            Esta empresa se dedica a brindar un servicio de préstamos a un conjunto de personas que lo solicite, y a su vez
                            existe una comunidad virtual donde las personas pueden compartir alguna noticia o hacer un comentario donde podran 
                            interactuar con reacciones.
                        </p>
                    </div>
                </div>

                <div class="items-center">
                    <p class="font-semibold text-gray-800 dark:text-white text-center">Contacto</p>
                    <div class="flex flex-col items-center mt-5 space-y-2">
                        <h6 class="text-gray-600 transition-colors duration-300 dark:text-gray-300 dark:hover:text-blue-400 hover:text-blue-500"><font-awesome-icon icon="phone" /> +52 (222) 888 8526</h6>
                        <h6 class="text-gray-600 transition-colors duration-300 dark:text-gray-300 dark:hover:text-blue-400 hover:text-blue-500 text-center"><font-awesome-icon icon="location-dot" /> Cerrada Allende 6, 72710 San Lorenzo Almecatla, Pue.</h6>
                        <h6 class="text-gray-600 transition-colors duration-300 dark:text-gray-300 dark:hover:text-blue-400 hover:text-blue-500"><font-awesome-icon icon="envelope" /> iesa@gmail.com</h6>
                    </div>
                </div>

                <div>
                    <p class="font-semibold text-gray-800 dark:text-white text-center">Redes Sociales</p>
                    <div class="flex flex-col items-center mt-5 space-y-2">
                        <a href="#" class="text-gray-600 transition-colors duration-300 dark:text-gray-300 dark:hover:text-blue-400 hover:text-blue-500"><font-awesome-icon icon="fa-brands fa-facebook" /> Siguenos en Facebook</a>
                        <a href="#" class="text-gray-600 transition-colors duration-300 dark:text-gray-300 dark:hover:text-red-400 hover:text-red-500"><font-awesome-icon icon="fa-brands fa-youtube" /> Siguenos en YouTube</a>
                        <a href="#" class="text-gray-600 transition-colors duration-300 dark:text-gray-300 dark:hover:text-cyan-400 hover:text-cyan-400"><font-awesome-icon icon="fa-brands fa-twitter" />Siguenos en Twitter</a>
                    </div>
                </div>
            </div>
        
            <hr class="my-6 border-gray-100 md:my-8 dark:border-gray-700">
        
            <div class="flex items-center justify-between">
                <Link href="/">
                    <img class="w-auto h-7" src="https://persuacion.000webhostapp.com/logotipo.png" alt="">
                </Link>
                
                <div class="flex -mx-2">
                    <p class="text-black text-sm">
                        © Todos los Derechos Reservados | Persuación
                    </p>
                </div>
            </div>
        </div>
    </footer>
</template>
