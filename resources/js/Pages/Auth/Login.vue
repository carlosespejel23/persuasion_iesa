<script setup lang="ts">
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import ButtonNav from '@/components/ButtonNav.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import TextInputEmail from '@/components/TextInputEmail.vue';
import TextInputPassword from '@/components/TextInputPassword.vue';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faCircleArrowRight, faCircleArrowLeft } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
library.add(faCircleArrowRight, faCircleArrowLeft);

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

<template>

    <Head>
        <title>
            Login | Persuación
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
                        <Link href="/">
                            <ButtonNav class="ml-4 bg-white">
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
                            <h3 class="pt-4 text-2xl text-center"><b>Inicio de Sesión</b></h3>
                        </div>

                            <!--Input de Email o Correo Electronico-->
							<div class="mb-4">
								<TextInputEmail
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
                                <TextInputPassword
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
                                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Recuerdame</span>
                                </label>
							</div>

							<div class="mb-6 text-center">
                                <!--Link para redireccionar al formulario de recuperar contraseña-->
                                <Link
                                    v-if="canResetPassword"
                                    :href="route('password.request')"
                                    class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                                >
                                    ¿Olvidaste tu Contraseña?
                                </Link>
                                
                                <!--Button para tener el acceso-->
                                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" style="background: #0065b5;">
                                    Entrar&nbsp<font-awesome-icon icon="circle-arrow-right" />
                                </PrimaryButton>
							</div>

							<hr class="mb-6 border-t" />

                            <!--Link para acceder al formulario de registro-->
							<div class="text-center">
                                <p align="center" style="font-size: small;">¿No tienes Cuenta? 
                                <Link
                                    :href="route('register')"
                                    class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                                >
                                    Registrate
                                </Link></p>
							</div>
					</form>
				</div>
            </div>
        </div>
    </div>
</template>