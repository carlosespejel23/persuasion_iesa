<script setup lang="ts">
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/components/InputError.vue';
import InputLabel from '@/components/InputLabel.vue';
import PrimaryButton from '@/components/PrimaryButton.vue';
import TextInput from '@/components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';

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

<style>
    .image{
        background-image: url("https://www.anahuac.mx/generacion-anahuac/sites/default/files/inline-images/educacion.financiera-1.jpg");
        background-position: center;
        background-size: cover;
        height: calc(3.2 * 10em);
    }
</style>

<template>
    <div class="p-10 bg-gray-200 h-[100vh] flex items-center justify-center">
        <div class="bg-white shadow-lg overflow-hidden rounded-xl w-[60%] h-[30em] z-50">
            <div class="flex space-between items-start">
                <div class="image lg:w-[50%] xs:hidden">
                    <!--Aqui se mostrara una imagen de fondo-->
                </div>
                
                <div class="lg:w-[50%] xs:w-full sm:w-full px-8 py-10">
                    <div>
                        <div v-if="status" class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ status }}
                        </div>

                        <!--Comienza el formulario de enviar correo-->
                        <form @submit.prevent="submit">

                            <!--Logo de la empresa-->
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
                                <p class="text-3xl text-gray-800" align="center">
                                   <b>¡Recupera tu Contraseña!</b>
                                </p>
                            </div>
                            <br>

                            <!--Texto de indicacion-->
                            <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                                <p class="texto" align="center">
                                    Introduce el correo electrónico con el que te registraste en Persuación y te enviaremos un email para actualizar tu contraseña.
                                </p>
                            </div>

                            <!--Input de correo electronico-->
                            <div>
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
                                />

                                <InputError class="mt-2" :message="form.errors.email" />
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <PrimaryButton 
                                    :class="{ 'opacity-25': form.processing }" 
                                    :disabled="form.processing"
                                    style="background: #E26519;"
                                >
                                    Enviar
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>