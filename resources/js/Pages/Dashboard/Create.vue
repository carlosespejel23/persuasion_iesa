<script setup lang="ts">
import GuestLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';
import Checkbox from '@/Components/Checkbox.vue';
import { usePage } from '@inertiajs/vue3';

defineProps<{
    mustVerifyEmail?: Boolean;
    status?: String;
}>();

const user = usePage().props.auth.user;

const form = useForm({
    usuarios_id: user.id,
    contenido: '',
    post_anonimo: '',
});

const submit = () => {
    form.post(route('dashboard.save'), {
        onFinish: () => form.reset('contenido', 'post_anonimo'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Crear Noticia" />

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="contenido" value="Contenido" />

                <TextInput
                    id="contenido"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.contenido"
                    required
                    autofocus
                    autocomplete="contenido"
                />

                <InputError class="mt-2" :message="form.errors.contenido" />
            </div>

            <div>
                <!--Aqui haz que el checkbox tenga un valor predeterminado de 0 porque el valor no esta definido en el form cuando no se toca el checkbox-->
                <Checkbox
                    id="post_anonimo"
                    v-model="form.post_anonimo"
                    name="post_anonimo"
                    value=1
                    unchecked-value=0
                />

                <div>State: <strong>{{ form.post_anonimo }}</strong></div>

                <InputError class="mt-2" :message="form.errors.post_anonimo" />
            </div>

            <!--Este hidden para mandar el usuario autenticado-->
            <input type="hidden" v-model="form.usuarios_id"/>

            <div class="flex items-center justify-end mt-4">
                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Publicar Noticia
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>