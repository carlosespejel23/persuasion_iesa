<script setup lang="ts">
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import TextInputPassword from '@/components/TextInputPassword.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faCircleCheck } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
library.add(faCircleCheck);

const form = useForm({
    password: '',
});

const submit = () => {
    form.post(route('password.confirm'), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <div class="max-w-lg mx-auto my-10 bg-white p-10 rounded-xl border">
        <center>
            <img src="https://persuacion.000webhostapp.com/logotipo.png" width="100" />
            <br>
            <h1 class="text-4xl font-medium">Confirmar Contraseña</h1>
        </center>
        <p class="text-slate-500 text-center">
            Esta es un área segura de la aplicación. Por favor, confirme su contraseña antes de continuar.
        </p>
        <form @submit.prevent="submit">

            <div class="flex flex-col space-y-5">

                <div>
                    <TextInputPassword
                        id="password"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password"
                        required
                        autocomplete="current-password"
                        autofocus
                    />

                    <InputError class="mt-2" :message="form.errors.email" />
                </div>
               
                <div class="flex items-center justify-end mt-4">
                    <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" style="background: #0065b5;">
                        <font-awesome-icon icon="circle-check" /> &nbspConfirmar Contraseña
                    </PrimaryButton>
                </div>
            </div>
        </form>
    </div>
</template>
