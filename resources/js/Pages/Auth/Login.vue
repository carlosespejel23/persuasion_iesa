<script setup lang="ts">
import Checkbox from '@/components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/components/InputError.vue';
import InputLabel from '@/components/InputLabel.vue';
import PrimaryButton from '@/components/PrimaryButton.vue';
import TextInput from '@/components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import 'boxicons';

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
    .image{
        background-image: url("https://www.anahuac.mx/generacion-anahuac/sites/default/files/inline-images/educacion.financiera-1.jpg");
        background-position: center;
        background-size: cover;
        height: calc(3.2 * 10em);
    }
</style>

<template>

    <head>
        <link href="https://cdn.jsdelivr.net/npm/vuesax/dist/vuesax.css" rel="stylesheet">
        <link rel="stylesheet" href="boxicons.min.css">
    </head>

    

    <div class="p-10 bg-gray-200 h-[100vh] flex items-center justify-center">
        <div class="bg-white shadow-lg overflow-hidden rounded-xl w-[60%] h-[30em] z-50">
            <div class="flex space-between items-start">
                <div class="lg:w-[50%] xs:w-full sm:w-full px-8 py-10">
                    <div>
                        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                            {{ status }}
                        </div>

                        <!--Comienza formulario-->
                        <form @submit.prevent="submit">

                            <!--logo de Empresa-->
                            <div>
                                <center>
                                    <img 
                                        src="https://persuacion.000webhostapp.com/persuacion.png" 
                                        class="logo"
                                        alt=""
                                        :width="120"
                                    />
                                </center>
                                <br>
                                <p class="text-4xl text-gray-800" align="center">
                                   <b>Bienvenido</b>
                                </p>
                                <p class="text-2xl text-gray-800" align="center">
                                   Inicio Sesión
                                </p>
                            </div>

                            <!--Seccion para email-->
                            <div class="mt-4">
                                <InputLabel for="email" value="Correo Electrónico" />
                                <TextInput
                                    id="email"
                                    type="email"
                                    class="mt-1 block w-full"
                                    v-model="form.email"
                                    placeholder="example@gmail.com"
                                    required
                                    autofocus
                                    autocomplete="username"
                                    icon="user"
                                />
                                <i class='bx bx-user'></i>
                                <InputError class="mt-2" :message="form.errors.email" />
                            </div>

                            <!--Seccion para la contraseña-->
                            <div class="mt-4">
                                <InputLabel for="password" value="Contraseña" />
                                <TextInput
                                    id="password"
                                    type="password"
                                    class="mt-1 block w-full"
                                    v-model="form.password"
                                    placeholder="Password"
                                    required
                                    autocomplete="current-password"
                                />
                                <InputError class="mt-2" :message="form.errors.password" />
                            </div>

                            <!--Seccion para remember me y olvidaste -->
                            <div class="block mt-4">
                                <label class="flex items-center">
                                    <Checkbox name="remember" v-model:checked="form.remember" />
                                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Recuerdame</span>
                                </label>
                            </div>
                            
                            <!--prueba-->
                            <div class="flex items-center justify-end mt-4">
                                <Link
                                    v-if="canResetPassword"
                                    :href="route('password.request')"
                                    class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                                >
                                    ¿Olvidaste tu Contraseña?
                                </Link>
                                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" style="background: #E26519;">
                                        Entrar
                                </PrimaryButton>
                            </div>
                            
                            <!--prueba2-->
                        </form>
                    </div>
                </div>

                <div class="image lg:w-[50%] xs:hidden">
                    <!--Aqui se mostrara una imagen de fondo-->
                </div>
            </div>
        </div>
    </div>
</template>
