<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInputEmail from '@/components/TextInputEmail.vue';
import TextInputPassword from '@/components/TextInputPassword.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps<{
    email: string;
    token: string;
}>();

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    
    <Head>
        <title>
            Restablecer Contraseña | Persuación
        </title>
    </Head>

    <!--Barra de navegacion-->
    <nav class="bg-white px-6 relative shadow-md">
        <div class="flex flex-row justify-between items-center py-2">
            <Link href="/"><img src="https://persuacion.000webhostapp.com/logotipo.png" width="100" /></Link>
        </div>
    </nav>

    <!--Formulario de Reestablecer Contraseña-->
    <div class="max-w-lg mx-auto my-10 bg-white p-10 rounded-xl border">

        <h1 class="text-4xl font-medium text-center text-black">Restablecer Contraseña</h1>
        <p class="text-slate-500 text-center text-black">
            Ingresa el correo electrónico y la contraseña para seguir con el proceso.
        </p>
        <form @submit.prevent="submit">

            <div class="flex flex-col space-y-5">

                <div>
                    <TextInputEmail
                        id="email"
                        type="email"
                        class="mt-1 block w-full"
                        v-model="form.email"
                        required
                        autofocus
                        autocomplete="username"
                    />

                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div>
                    <TextInputPassword
                        id="password"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password"
                        required
                        autocomplete="new-password"
                    />

                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <div>
                    <TextInputPassword
                        id="password_confirmation"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password_confirmation"
                        required
                        autocomplete="new-password"
                    />

                    <InputError class="mt-2" :message="form.errors.password_confirmation" />
                </div>
               
                <div class="flex items-center justify-end mt-4">
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing" style="background: #0065b5;">
                        Restablecer
                    </PrimaryButton>
                </div>

            </div>
        </form>
    </div>    

</template>
