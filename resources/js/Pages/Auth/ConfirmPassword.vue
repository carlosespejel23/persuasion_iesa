<script setup lang="ts">
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/components/InputError.vue';
import TextPassword from '@/components/TextPassword.vue';
import PrimaryButton from '@/components/PrimaryButton.vue';
import { Head, useForm } from '@inertiajs/vue3';

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

    <Head>
        <title>
            Confirmar Contraseña | Persuasión
        </title>

        <link rel="icon" href="/images/icono.png" type="image/x-icon">
    </Head>

    <!--Barra de navegacion-->
    <nav class="bg-blue-950 px-6 relative shadow-md">
        <div class="flex flex-row justify-between items-center py-2">
            <Link href="/"><img src="/images/logob.png" width="100" /></Link>
        </div>
    </nav>

    <div class="max-w-lg mx-auto my-10 bg-white p-10 rounded-xl border">
        <h1 class="text-4xl text-center font-medium">Confirmar Contraseña</h1>
        <br>
        <p class="text-slate-500 text-center">
            Esta es un área segura de la aplicación. Por favor, confirme su contraseña antes de continuar.
        </p>
        <form @submit.prevent="submit">

            <div class="flex flex-col space-y-5">

                <div>
                    <TextPassword
                        id="password"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password"
                        required
                        autocomplete="current-password"
                        autofocus
                    />

                    <InputError class="mt-2" :message="form.errors.password" />
                </div>
               
                <div class="flex items-center justify-end mt-4">
                    <PrimaryButton class="ml-4 bg-blue-950" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Confirmar
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
                            La empresa Persuasion Financial App es una red de comunicación e interacción social que ofrece a sus usuarios el poder dar de alta a deudores, hacer publicaciones de cualquier índole, así también como una experiencia sin censura y de libre expresión de temas de cualquier tipo siendo una red abierta a todo el público.
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
