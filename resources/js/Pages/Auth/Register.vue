<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import ModalContrato from '@/components/ModalContrato.vue';
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
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
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