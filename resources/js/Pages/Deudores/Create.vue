<script setup lang="ts">
import GuestLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import { defineProps, ref } from 'vue';

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
    <GuestLayout>
        <Head title="Nuevo Deudor" />

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

            <div class="mt-4">
                <InputLabel for="email" value="Email" />

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

            <!--Aqui le pones el input para que vea que registra dinero, ahora solo lo manda por en text input-->
            <div>
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

            <div class="flex items-center justify-end mt-4">
                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Agregar Deudor
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>