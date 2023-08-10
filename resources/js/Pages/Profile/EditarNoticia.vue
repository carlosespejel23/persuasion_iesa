<script setup lang="ts">
import GuestLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import { Noticia } from '@/types';
import { ref } from 'vue';

defineProps<{
    mustVerifyEmail?: Boolean;
    status?: String;
}>();

const user = usePage().props.auth.user;
const noticia = ref<Noticia | null>(usePage().props.noticia as Noticia || null);

const form = useForm({
    usuarios_id: user.id,
    contenido: noticia.value ? noticia.value.contenido : null,
});

const submit = () => {
    form.patch(route('update.noticia', { id: noticia.value.id }), {
        onFinish: () => form.reset('contenido'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head>
            <title>
                Nueva Noticia | Persuasión
            </title>
            <link rel="icon" href="/images/icono.png" type="image/x-icon">
        </Head>

        <template #header>
            <h2 class="font-semibold text-xl text-white leading-tight text-center">Actualizar Noticia</h2>
        </template><br>

        <div class="max-w-6xl px-10 mx-auto sm:px-6 lg:px-8">
            <form @submit.prevent="submit">
                <div>
                    <InputLabel for="contenido" value="Contenido" />

                    <TextInput
                        id="contenido"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.contenido"
                        :value="form.contenido"
                        required
                        autofocus
                        autocomplete="contenido"
                    />

                    <InputError class="mt-2" :message="form.errors.contenido" />
                </div><br>

                <!--Este hidden para mandar el usuario autenticado-->
                <input type="hidden" v-model="form.usuarios_id"/>

                <div class="flex items-center justify-end mt-4">
                    <PrimaryButton class="ml-4 bg-blue-950" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Actualizar Noticia
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </GuestLayout>
</template>