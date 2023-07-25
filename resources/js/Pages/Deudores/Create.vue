<script setup lang="ts">
import GuestLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import { defineProps, ref } from 'vue';
import { library } from '@fortawesome/fontawesome-svg-core';
import {faIdBadge} from '@fortawesome/free-regular-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
library.add(faIdBadge);

defineProps<{
    mustVerifyEmail?: Boolean;
    status?: String;
}>();

const user = usePage().props.auth.user;

const form = useForm({
    usuario_id: user.id,
    nombre: '',
    apellidoPaterno: '',
    apellidoMaterno: '',
    email: '',
    telefono: '',
    monto_a_pagar: '',
});

const submit = () => {
    form.post(route('deudores.save'), {
        onFinish: () => form.reset('nombre', 'apellidoPaterno', 'apellidoMaterno', 'email', 'telefono', 'monto_a_pagar'),
    });
};
</script>

<template>
    
    <Head>
        <title>
            Nuevo Deudor | Persuación
        </title>
    </Head>

    <GuestLayout>

        <form @submit.prevent="submit">

            <div class="p-6 bg-white flex items-center justify-center">

                <div class="container max-w-screen-lg mx-auto">

                    <div>

                        <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6">

                            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-2">

                                <div class="lg:col-span-2">

                                    <center><img src="https://persuacion.000webhostapp.com/deudor.png" width="100" /></center>
                                    <h2 class="font-semibold text-xl text-gray-600 mb-6 text-center">Agregar Nuevo Deudor</h2>
                                    <hr>
                                    <br>
                                    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6">

                                        <div class="md:col-span-3">
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

                                        <div class="md:col-span-3">
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

                                        <div class="md:col-span-3">
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

                                        <div class="md:col-span-3">
                                            <InputLabel for="telefono" value="Teléfono" />

                                            <TextInput
                                                id="telefono"
                                                type="text"
                                                class="mt-1 block w-full"
                                                v-model="form.telefono"
                                                required
                                                autofocus
                                                autocomplete="telefono"
                                            />

                                            <InputError class="mt-2" :message="form.errors.telefono" />
                                        </div>

                                        <div class="md:col-span-3">
                                            <InputLabel for="email" value="Correo Electrónico" />

                                            <TextInput
                                                id="email"
                                                type="email"
                                                class="mt-1 block w-full"
                                                v-model="form.email"
                                                required
                                                autocomplete="email"
                                            />

                                            <InputError class="mt-2" :message="form.errors.email" />
                                        </div>

                                        <div class="md:col-span-3">
                                            <InputLabel for="monto_a_pagar" value="Monto a pagar" />

                                            <TextInput
                                                id="monto_a_pagar"
                                                type="text"
                                                class="mt-1 block w-full"
                                                v-model="form.monto_a_pagar"
                                                required
                                                autofocus
                                                autocomplete="monto_a_pagar"
                                            />

                                            <InputError class="mt-2" :message="form.errors.monto_a_pagar" />
                                        </div>

                                        <!--Este hidden para mandar el usuario autenticado-->
                                        <input type="hidden" v-model="form.usuario_id"/>
                                        
                                    </div>

                                    <div class="flex items-center justify-end mt-4">
                                        <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                            Agregar Deudor
                                        </PrimaryButton>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </GuestLayout>
</template>