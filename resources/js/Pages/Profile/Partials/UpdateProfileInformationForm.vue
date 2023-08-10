<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

defineProps<{
    mustVerifyEmail?: Boolean;
    status?: String;
}>();

const user = usePage().props.auth.user;

//Formulario de Datos
const form = useForm({
    nombre: user.nombre,
    apellidoPaterno: user.apellidoPaterno,
    apellidoMaterno: user.apellidoMaterno,
    telefono: user.telefono,
    email: user.email,
});
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Información del Perfil</h2>

            <p class="mt-1 text-sm text-gray-600">
                Actualice la información de perfil y la dirección de correo electrónico de su cuenta.
            </p>
        </header>

        <form @submit.prevent="form.patch(route('profile.update'))" class="mt-6 space-y-6">

            <div class="lg:col-span-2">
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
                            maxlength="50"
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
                            maxlength="50"
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
                            maxlength="50"
                        />

                        <InputError class="mt-2" :message="form.errors.apellidoMaterno" />
                    </div>

                    <div class="md:col-span-3">
                        <InputLabel for="telefono" value="Telefono" />

                        <TextInput
                            id="telefono"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.telefono"
                            required
                            autofocus
                            autocomplete="telefono"
                            maxlength="10"
                        />

                        <InputError class="mt-2" :message="form.errors.telefono" />
                    </div>

                    <div class="md:col-span-6">
                        <InputLabel for="email" value="Correo Electrónico" />

                        <TextInput
                            id="email"
                            type="email"
                            class="mt-1 block w-full"
                            v-model="form.email"
                            required
                            autocomplete="username"
                            maxlength="60"
                        />

                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>
                </div>
            </div>

            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="text-sm mt-2 text-gray-800">
                    Su dirección de correo electrónico no está verificada.
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                    Haga clic aquí para volver a enviar el correo electrónico de verificación.
                    </Link>
                </p>

                <div
                    v-show="status === 'verification-link-sent'"
                    class="mt-2 font-medium text-sm text-green-600"
                >
                Se ha enviado un nuevo enlace de verificación a su dirección de correo electrónico.
                </div>
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing" class="bg-blue-950">Guardar</PrimaryButton>

                <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Guardado.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
