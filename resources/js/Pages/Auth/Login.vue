<script setup lang="ts">
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextEmail from '@/components/TextEmail.vue';
import GuestLayout from '@/components/GuestLayout.vue';
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
            Login | Persuasión
        </title>
        <link rel="icon" href="/images/icono.png" type="image/x-icon">
    </Head>

    <!--Barra de navegacion-->
    <nav class="bg-blue-950 px-6 relative shadow-md">
        <div class="flex flex-row justify-between items-center py-2">
            <Link href="/"><img src="/images/logob.png" width="100" /></Link>
        </div>
    </nav>

    <!--Comienza el fomrulario de inicio de sesion-->
    <form class="px-6" @submit.prevent="submit">

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

            <div class="container mx-auto">
                <div class="flex justify-center px-6 my-12">
                    <div class="w-full xl:w-3/4 lg:w-11/12 flex">

                        <!--Primera parte del login que es una imagen-->
                        <div class="w-full h-auto bg-gray-400 hidden lg:block lg:w-1/2 bg-cover rounded-l-lg" 
                            style="background-image: url('https://posgradosadistancia.com.ar/wp-content/uploads/2021/04/Objetivos-de-las-Finanzas.jpg')">
                            <!--Aqui va una imagen haciendo referencia a la app-->
                        </div>

                        <!--Segunda parte del login que donde se ubican los input-->
                        <div class="w-full lg:w-1/2 border p-10 rounded-lg lg:rounded-l-none">
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
                        </div>
                    </div>
                </div>
            </div>
    </form> 

    <!-- Footer -->
    <footer class="bg-blue-950 border-top">

        <div class="container px-6 py-12 mx-auto">

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 sm:gap-y-10 lg:grid-cols-4">

                <div class="sm:col-span-12">

                    <center><h1 class="max-w-lg text-xl font-semibold tracking-tight text-white xl:text-2xl">Libertad de Expresión y Seguridad Financiera</h1></center>

                    <div class="flex flex-col mx-auto mt-6 space-y-3 md:space-y-0 md:flex-row">
                    
                        <p class="text-center text-white">
                            La empresa Persuasion Financial App es una red de comunicación e interacción social que ofrece a sus usuarios el poder dar de alta a deudores, hacer publicaciones de cualquier índole, así también como una experiencia sin censura y de libre expresión de temas de cualquier tipo siendo una red abierta a todo el público.
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
                        © Todos los Derechos Reservados | Persuasión
                    </p>
                </div>
            </div>
        </div>
    </footer>
</template>