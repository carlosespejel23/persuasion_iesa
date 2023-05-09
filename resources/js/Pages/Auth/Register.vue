<script setup lang="ts">
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Checkbox from '@/Components/Checkbox.vue';

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

<template>
    <GuestLayout>
        <Head title="Register" />

        <form @submit.prevent="submit">
            <div>
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

            <div>
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

            <div>
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

            <div>
                <InputLabel for="telefono" value="Telefono" />

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

            <div>
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

            <div class="mt-4">
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />

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

            <div class="mt-4">
                <InputLabel for="password_confirmation" value="Confirm Password" />

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

            <div>
                <Checkbox
                    id="acepto_contrato"
                    v-model="form.acepto_contrato"
                    name="acepto_contrato"
                    value=1
                    unchecked-value=0
                />

                <div>State: <strong>{{ form.acepto_contrato }}</strong></div>

                <InputError class="mt-2" :message="form.errors.acepto_contrato" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link
                    :href="route('login')"
                    class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                >
                    Already registered?
                </Link>

                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Register
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
