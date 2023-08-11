<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextEmail from '@/components/TextEmail.vue';
import TextPassword from '@/components/TextPassword.vue';
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
            Restablecer Contraseña | Persuasión
        </title>
        <link rel="icon" href="/images/icono.png" type="image/x-icon">
    </Head>

    <!--Barra de navegacion-->
    <nav class="bg-blue-950 px-6 relative shadow-md">
        <div class="flex flex-row justify-between items-center py-2">
            <Link href="/"><img src="/images/logob.png" width="100" /></Link>
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
                    <TextEmail
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
                    <TextPassword
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
                    <TextPassword
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
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing" class="bg-blue-950">
                        Restablecer
                    </PrimaryButton>
                </div>

            </div>
        </form>
    </div>

    <!-- Footer -->
    <footer class="bg-blue-950 border-top">

        <div class="container px-6 py-12 mx-auto">

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 sm:gap-y-10 lg:grid-cols-4">

                <div class="sm:col-span-12">

                    <center><h1 class="max-w-lg text-xl font-semibold tracking-tight text-white xl:text-2xl">Libertad de Expresión y Seguridad Financiera</h1></center>

                    <div class="flex flex-col mx-auto mt-6 space-y-3 md:space-y-0 md:flex-row">
                    
                        <p class="text-center text-white">
                            Esta empresa se dedica a brindar un servicio de préstamos a un conjunto de personas que lo solicite, y a su vez
                            existe una comunidad virtual donde las personas pueden compartir alguna noticia o hacer un comentario donde podran 
                            interactuar con reacciones.
                        </p>
                    </div>
                </div>
            </div>

            <hr class="my-6 border-gray-100 md:my-8">

            <div class="flex items-center justify-between">
                <Link href="/">
                    <img class="w-auto h-7" src="/images/logob.png" alt="">
                </Link>
                
                <div class="flex -mx-2">
                    <p class="text-white text-sm">
                        © Todos los Derechos Reservados | Persuasión
                    </p>
                </div>
            </div>
        </div>
    </footer>    

</template>
