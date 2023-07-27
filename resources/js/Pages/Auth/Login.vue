<script setup lang="ts">
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import ButtonNav from '@/components/ButtonNav.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextEmail from '@/components/TextEmail.vue';
import TextPassword from '@/components/TextPassword.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faCircleArrowRight, faCircleArrowLeft, faPhone, faLocationDot, faEnvelope, faBars } from '@fortawesome/free-solid-svg-icons';
import {faSquareFacebook, faSquareTwitter, faSquareYoutube} from '@fortawesome/free-brands-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
library.add(faBars, faCircleArrowRight, faCircleArrowLeft, faPhone, faLocationDot, faEnvelope, faSquareFacebook, faSquareTwitter, faSquareYoutube);

defineProps<{
    canResetPassword?: boolean;
    status?: string;
}>();

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<style>
      .smaller-text {
        font-size: 15px;
      }

      .face, .you, .twi{
        font-size: 180%;
      }
      
      .fabards{
        font-size: 150%;
        color: white;
      }
</style>

<template>

    <Head>
        <title>
            Login | Persuación
        </title>
    </Head>

    <!--Barra de navegacion-->
    <nav class="bg-blue-950 px-6 relative shadow-md">
        <div class="flex flex-row justify-between items-center py-2">
            <Link href="/"><img src="https://persuacion.000webhostapp.com/logob.png" width="100" /></Link>

            <div class="group flex flex-col items-center">

                <button class="p-2 rounded-lg md:hidden">
                    <font-awesome-icon icon="fa-solid fa-bars" class="fabards" />
                </button>

                <div class="hidden group-hover:block md:block absolute md:static bg-blue-950 inset-x-0 top-16 py-3 shadow-md md:shadow-none text-gray-600">
                    <div class="flex flex-row justify-center items-center text-center font-semibold text-gray-500">
                        <Link href="/">
                            <ButtonNav>
                                <font-awesome-icon icon="circle-arrow-left" />&nbspRegresar
                            </ButtonNav>
                        </Link>
                    </div>
                </div>
            </div>

        </div>
    </nav>  

    <!--Aqui empieza el formulario dentro de un container-->
    <div class="container mx-auto">

        <!--Aqui es para crear contenedor flexible centrado horizontalmente-->
        <div class="flex justify-center px-6 my-12">

            <!--Parte donde se adaptara a todas las pantallas-->
            <div class="w-full xl:w-3/4 lg:w-11/12 flex">

                <!--Primera parte del login que es una imagen-->
                <div class="w-full h-auto bg-gray-400 hidden lg:block lg:w-1/2 bg-cover rounded-l-lg" 
                    style="background-image: url('https://posgradosadistancia.com.ar/wp-content/uploads/2021/04/Objetivos-de-las-Finanzas.jpg')">
                    <!--Aqui va una imagen haciendo referencia a la app-->
                </div>
                

                <!--Segunda parte del login que donde se ubican los input-->
                <div class="w-full lg:w-1/2 border p-2 rounded-lg lg:rounded-l-none">

                    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                            {{ status }}
                    </div>

                    <!--Comienza el formulrio-->
					<form class="px-8 pt-6 mb-4  rounded" @submit.prevent="submit">

                        <div class="mb-4">
                            <h3 class="pt-4 text-4xl text-center"><b>Inicio de Sesión</b></h3>
                        </div>

                            <!--Input de Email o Correo Electronico-->
							<div class="mb-4">
								<TextEmail
                                    id="email"
                                    type="email"
                                    class="mt-1 block w-full"
                                    v-model="form.email"
                                    autofocus
                                    autocomplete="username"
                                />
                                <InputError class="mt-2" :message="form.errors.email" />
							</div>

                            <!--Input de Password-->
							<div class="mb-4">
                                <TextPassword
                                    id="password"
                                    type="password"
                                    class="mt-1 block w-full"
                                    v-model="form.password"
                                    autocomplete="current-password"
                                />
                                <InputError class="mt-2" :message="form.errors.password" />
                            </div>

                            <!--Checkbox de recordar sesión-->
							<div class="mb-4">
                                <label class="flex items-center">
                                    <Checkbox name="remember" v-model:checked="form.remember" />
                                    <span class="ml-2 text-sm text-gray-600">Recuerdame</span>
                                </label>
							</div>

							<div class="mb-6 text-center">
                                <!--Link para redireccionar al formulario de recuperar contraseña-->
                                <Link
                                    v-if="canResetPassword"
                                    :href="route('password.request')"
                                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                >
                                    ¿Olvidaste tu Contraseña?
                                </Link>
                                
                                <!--Button para tener el acceso-->
                                <PrimaryButton class="ml-4 bg-blue-950" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Entrar&nbsp<font-awesome-icon icon="circle-arrow-right" />
                                </PrimaryButton>
							</div>

							<hr class="mb-6 border-t" />

                            <!--Link para acceder al formulario de registro-->
							<div class="text-center">
                                <p class="text-center" style="font-size: small;">¿No tienes Cuenta? 
                                <Link
                                    :href="route('register')"
                                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                >
                                    Registrate
                                </Link></p>
							</div>
					</form>
				</div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-blue-950 border-top">

        <div class="container px-6 py-12 mx-auto">

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 sm:gap-y-10 lg:grid-cols-4">
                <div class="sm:col-span-2">
                    <h1 class="max-w-lg text-xl font-semibold tracking-tight text-white xl:text-2xl">Libertad de Expresión y Seguridad Financiera</h1>

                    <div class="flex flex-col mx-auto mt-6 space-y-3 md:space-y-0 md:flex-row">
                    
                        <p class="text-justify text-white">
                            Esta empresa se dedica a brindar un servicio de préstamos a un conjunto de personas que lo solicite, y a su vez
                            existe una comunidad virtual donde las personas pueden compartir alguna noticia o hacer un comentario donde podran 
                            interactuar con reacciones.
                        </p>
                    </div>
                </div>

                <div class="items-center">
                    <h1 class="max-w-lg text-xl font-semibold tracking-tight text-white xl:text-2xl text-center">Contacto</h1>
                    <div class="flex flex-col items-center">
                        <h6 class="text-white transition-colors duration-300 hover:text-blue-500"><font-awesome-icon icon="phone" /> +52 (222) 888 8526</h6>
                        <h6 class="text-white transition-colors duration-300 hover:text-blue-500 text-center"><font-awesome-icon icon="location-dot" /> Cerrada Allende 6, 72710 San Lorenzo Almecatla, Pue.</h6>
                        <h6 class="text-white transition-colors duration-300 hover:text-blue-500"><font-awesome-icon icon="fa-solid fa-envelope" /> iesa@gmail.com</h6>
                    </div>
                </div>

                <div>
                    <h1 class="max-w-lg text-xl font-semibold tracking-tight text-white xl:text-2xl text-center">Redes Sociales</h1>
                    <div class="flex flex-col items-center">
                        <a href="https://es-la.facebook.com/" class="text-white transition-colors duration-300 hover:text-blue-500"><font-awesome-icon icon="fa-brands fa-square-facebook" class="face" /></a>
                        <a href="#" class="text-white transition-colors duration-300 hover:text-red-500"><font-awesome-icon icon="fa-brands fa-square-youtube" class="you" /></a>
                        <a href="#" class="text-white transition-colors duration-300 hover:text-cyan-400"><font-awesome-icon icon="fa-brands fa-square-twitter" class="twi" /></a>
                    </div>
                </div>
            </div>

            <hr class="my-6 border-gray-100 md:my-8">

            <div class="flex items-center justify-between">
                <Link href="/">
                    <img class="w-auto h-7" src="https://persuacion.000webhostapp.com/logob.png" alt="">
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