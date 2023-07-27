<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import ModalContrato from '@/components/ModalContrato.vue';
import ButtonNav from '@/components/ButtonNav.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Checkbox from '@/Components/Checkbox.vue';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faUser, faUserPlus, faCircleArrowLeft, faPhone, faLocationDot, faEnvelope } from '@fortawesome/free-solid-svg-icons';
import {faSquareFacebook, faSquareTwitter, faSquareYoutube} from '@fortawesome/free-brands-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
library.add(faUser, faUserPlus, faCircleArrowLeft, faSquareFacebook, faSquareTwitter, faSquareYoutube, faPhone, faLocationDot, faEnvelope);

const form = useForm({
    nombre: '',
    apellidoPaterno: '',
    apellidoMaterno: '',
    telefono: '',
    fecha_de_nacimiento: '',
    acepto_contrato: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
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
</style>

<template>

    <Head>
        <title>
            Registro | Persuación
        </title>
    </Head>

    <!--Barra de navegacion-->
    <nav class="bg-blue-950 px-6 relative shadow-md">
        <div class="flex flex-row justify-between items-center py-2">
            <Link href="/"><img src="https://persuacion.000webhostapp.com/logob.png" width="100" /></Link>

            <div class="group flex flex-col items-center">

                <button class="p-2 rounded-lg md:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="h-10 fill-current" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" /></svg>
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

    <!--Aqui empieza el formulario-->
    <form @submit.prevent="submit" class="px-8 pt-6 mb-4 rounded w-full xl:w-3/4 lg:w-12/12 mx-auto">

        <div class="bg-white shadow-md rounded border-2 px-8 pt-6 pb-8 mb-4 flex flex-col my-2">

            <div class="mb-4">
                <h3 class="pt-4 text-4xl text-center"><b>Registro Nuevo Usuario</b></h3>
            </div>

            <hr>
            <br>

            <div class="-mx-3 md:flex">

                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <!--Input de Nombre-->
                    <div class="mb-4">
                        <InputLabel for="nombre" value="Nombre" />

                        <TextInput
                            id="nombre"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.nombre"
                            required
                            autofocus
                            autocomplete="nombre"
                        />

                        <InputError class="mt-2" :message="form.errors.nombre" />
                    </div>
                </div>

                <div class="md:w-1/2 px-3">
                    <!--Input de Apellido Paterno-->
                    <div class="mb-4">
                        <InputLabel for="apellidoPaterno" value="Apellido Paterno" />

                        <TextInput
                            id="apellidoPaterno"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.apellidoPaterno"
                            required
                            autofocus
                            autocomplete="apellidoPaterno"
                        />

                        <InputError class="mt-2" :message="form.errors.apellidoPaterno" />
                    </div>
                </div>
                
            </div>

            <div class="-mx-3 md:flex">

                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <!--Input de Apellido Materno-->
                    <div class="mb-4">
                        <InputLabel for="apellidoMaterno" value="Apellido Materno" />

                        <TextInput
                            id="apellidoMaterno"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.apellidoMaterno"
                            required
                            autofocus
                            autocomplete="apellidoMaterno"
                        />

                        <InputError class="mt-2" :message="form.errors.apellidoMaterno" />
                    </div>
                </div>

                <div class="md:w-1/2 px-3">
                    <!--Input de Telefono-->
                    <div class="mb-4">
                        <InputLabel for="telefono" value="Teléfono" />

                        <TextInput
                            id="telefono"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.telefono"
                            required
                            autofocus
                            autocomplete="telefono"
                            maxlength="10" 
                            pattern="[0-9]+"
                        />

                        <InputError class="mt-2" :message="form.errors.telefono" />
                    </div>
                </div>
            </div>

            <div class="-mx-3 md:flex">

                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <!--Input de Fecha de Nacimiento-->
                    <div class="mb-4">
                        <InputLabel for="fecha_de_nacimiento" value="Fecha de Nacimiento" />

                        <TextInput
                            id="fecha_de_nacimiento"
                            type="date"
                            class="mt-1 block w-full"
                            v-model="form.fecha_de_nacimiento"
                            required
                            autofocus
                            autocomplete="fecha_de_nacimiento"
                        />

                        <InputError class="mt-2" :message="form.errors.fecha_de_nacimiento" />
                    </div>
                </div>

                <div class="md:w-1/2 px-3">
                    <!--Input de Email-->
                    <div class="mb-4">
                        <InputLabel for="email" value="Correo Electrónico" />

                        <TextInput
                            id="email"
                            type="email"
                            class="mt-1 block w-full"
                            v-model="form.email"
                            required
                            placeholder="usuario@gmail.com"
                            autocomplete="username"
                        />

                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>
                </div>
            </div>

            <div class="-mx-3 md:flex">

                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <!--Input de Password-->
                    <div class="mb-4">
                        <InputLabel for="password" value="Contraseña" />

                        <TextInput
                            id="password"
                            type="password"
                            class="mt-1 block w-full"
                            v-model="form.password"
                            required
                            placeholder="***********"
                            autocomplete="new-password"
                        />

                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>
                </div>

                <div class="md:w-1/2 px-3">
                    <!--Input de Confirm Password-->
                    <div class="mb-4">
                        <InputLabel for="password_confirmation" value="Confirmar Contraseña" />

                        <TextInput
                            id="password_confirmation"
                            type="password"
                            class="mt-1 block w-full"
                            v-model="form.password_confirmation"
                            required
                            placeholder="***********"
                            autocomplete="new-password"
                        />

                        <InputError class="mt-2" :message="form.errors.password_confirmation" />
                    </div>
                </div>
            </div>

            <!--Checkbox de contrato-->
            <div class="mb-4">
                <Checkbox
                    id="acepto_contrato"
                    v-model="form.acepto_contrato"
                    name="acepto_contrato"
                    value=1
                    unchecked-value=0
                ></Checkbox>
                <span>&nbsp&nbsp<ModalContrato /><strong style="visibility:hidden;">{{ form.acepto_contrato }}</strong></span>
                    
                <InputError class="mt-2" :message="form.errors.acepto_contrato" />
            </div>

            <!--Button de Registro Acceso-->
            <div class="mb-4" align="right">
                <Link
                    :href="route('login')"
                    class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                >
                    ¿Ya tienes Cuenta?
                </Link>
                <PrimaryButton class="ml-4 bg-blue-950" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Registrarse
                </PrimaryButton>
            </div> 
        </div>
    </form>

    <!-- Footer -->
    <footer class="bg-blue-950 dark:bg-gray-900 border-top">

        <div class="container px-6 py-12 mx-auto">

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 sm:gap-y-10 lg:grid-cols-4">
                <div class="sm:col-span-2">
                    <h1 class="max-w-lg text-xl font-semibold tracking-tight text-white xl:text-2xl dark:text-white">Libertad de Expresión y Seguridad Financiera</h1>

                    <div class="flex flex-col mx-auto mt-6 space-y-3 md:space-y-0 md:flex-row">
                    
                        <p class="text-justify text-white">
                            Esta empresa se dedica a brindar un servicio de préstamos a un conjunto de personas que lo solicite, y a su vez
                            existe una comunidad virtual donde las personas pueden compartir alguna noticia o hacer un comentario donde podran 
                            interactuar con reacciones.
                        </p>
                    </div>
                </div>

                <div class="items-center">
                    <h1 class="max-w-lg text-xl font-semibold tracking-tight text-white xl:text-2xl dark:text-white text-center">Contacto</h1>
                    <div class="flex flex-col items-center">
                        <h6 class="text-white transition-colors duration-300 dark:text-gray-300 dark:hover:text-blue-400 hover:text-blue-500"><font-awesome-icon icon="phone" /> +52 (222) 888 8526</h6>
                        <h6 class="text-white transition-colors duration-300 dark:text-gray-300 dark:hover:text-blue-400 hover:text-blue-500 text-center"><font-awesome-icon icon="location-dot" /> Cerrada Allende 6, 72710 San Lorenzo Almecatla, Pue.</h6>
                        <h6 class="text-white transition-colors duration-300 dark:text-gray-300 dark:hover:text-blue-400 hover:text-blue-500"><font-awesome-icon icon="fa-solid fa-envelope" /> iesa@gmail.com</h6>
                    </div>
                </div>

                <div>
                    <h1 class="max-w-lg text-xl font-semibold tracking-tight text-white xl:text-2xl dark:text-white text-center">Redes Sociales</h1>
                    <div class="flex flex-col items-center">
                        <a href="https://es-la.facebook.com/" class="text-white transition-colors duration-300 dark:text-gray-300 dark:hover:text-blue-400 hover:text-blue-500"><font-awesome-icon icon="fa-brands fa-square-facebook" class="face" /></a>
                        <a href="#" class="text-white transition-colors duration-300 dark:text-gray-300 dark:hover:text-red-400 hover:text-red-500"><font-awesome-icon icon="fa-brands fa-square-youtube" class="you" /></a>
                        <a href="#" class="text-white transition-colors duration-300 dark:text-gray-300 dark:hover:text-cyan-400 hover:text-cyan-400"><font-awesome-icon icon="fa-brands fa-square-twitter" class="twi" /></a>
                    </div>
                </div>
            </div>

            <hr class="my-6 border-gray-100 md:my-8 dark:border-gray-700">

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