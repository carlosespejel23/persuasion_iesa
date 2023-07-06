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
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Profile Information</h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Update your account's profile information and email address.
            </p>
        </header>

        <form @submit.prevent="form.patch(route('profile.update'))" class="mt-6 space-y-6">

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

            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                    Your email address is unverified.
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                    >
                        Click here to re-send the verification email.
                    </Link>
                </p>

                <div
                    v-show="status === 'verification-link-sent'"
                    class="mt-2 font-medium text-sm text-green-600 dark:text-green-400"
                >
                    A new verification link has been sent to your email address.
                </div>
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600 dark:text-gray-400">Saved.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
