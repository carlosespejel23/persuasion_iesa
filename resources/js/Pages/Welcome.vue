<script setup lang="ts">
import { Link, Head } from '@inertiajs/vue3';
import ButtonNav from '@/components/ButtonNav.vue';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faUser, faUserPlus, faHouse, faRightToBracket, faUsers, faPhone, faLocationDot } from '@fortawesome/free-solid-svg-icons';
import {faEnvelope} from '@fortawesome/free-regular-svg-icons';
import {faFacebook, faTwitter, faYoutube} from '@fortawesome/free-brands-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
library.add(faUser, faUserPlus, faHouse, faRightToBracket, faUsers, faPhone, faLocationDot, faEnvelope, faFacebook, faTwitter, faYoutube);

defineProps<{
    canLogin?: boolean;
    canRegister?: boolean;
    laravelVersion: string;
    phpVersion: string;
}>();
</script>

<style>
     #menu-toggle:checked + #menu {
        display: block;
      }
      .smaller-text {
        font-size: 15px;
      }
</style>

<template>

    <Head>
        <title>
            Inicio | Persuación  
        </title>
        <link rel="icon" href="{{ asset('images/favicon.ico') }}">
    </Head>
    

    <!--Barra de navegacion-->
    <nav class="bg-white px-6 relative shadow-md" v-if="canLogin">

        <div class="flex flex-row justify-between items-center py-2">
            <Link href="/"><img src="https://persuacion.000webhostapp.com/logotipo.png" width="100" /></Link>

            <div class="group flex flex-col items-center"></div>

                <button class="p-2 rounded-lg md:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="h-10 fill-current" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" /></svg>
                </button>

                <div class="hidden group-hover:block md:block absolute md:static bg-white inset-x-0 top-16 py-3 shadow-md md:shadow-none text-gray-600">
                    <div class="flex flex-row justify-center items-center text-center font-semibold text-gray-500">
                        <Link :href="route('dashboard')" v-if="$page.props.auth.user">
                            <ButtonNav class="ml-4 bg-white smaller-text">
                                <font-awesome-icon icon="house" />&nbsp&nbspPanel Principal
                            </ButtonNav>
                        </Link>

                        <template v-else>
                            <Link :href="route('login')">
                                <ButtonNav class="ml-4 bg-white smaller-text">
                                    <font-awesome-icon icon="right-to-bracket" />&nbsp&nbspIniciar Sesión
                                </ButtonNav>
                            </Link>

                            <Link :href="route('register')" v-if="canRegister">
                                <ButtonNav class="ml-4 bg-white smaller-text">
                                    <font-awesome-icon icon="users" />&nbsp&nbspRegistrarse
                                </ButtonNav>
                            </Link>
                        </template>
                    </div>
                </div>
            </div>

        </div>
    </nav>





    <!-- Footer -->
    <!--<footer class="bg-white dark:bg-gray-900 border-top">

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
    </footer>-->

</template>

