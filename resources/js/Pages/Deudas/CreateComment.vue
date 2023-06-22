<script setup lang="ts">
import GuestLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { ComentarioActualizarDeuda } from '@/types';
import axios from 'axios';
import { ref, onMounted, defineProps } from 'vue';

defineProps<{
    mustVerifyEmail?: Boolean;
    status?: String;
}>();

const url = new URL(window.location.href);
const deudorId = url.pathname.split('/').pop();

const user = usePage().props.auth.user;

const form = useForm({
    usuario_id: user.id,
    deudor_id: deudorId,
    comentario: '',
});

const submit = () => {
    form.post(route('deudas.save'), {
        onFinish: () => form.reset('comentario'),
    });
};

//Esto es para extraer los comentarios en los deudores
const cad = ref<ComentarioActualizarDeuda[]>([]);
const uri = new URL(window.location.href);
const id = uri.pathname.split('/').pop();

onMounted(async () => {
  try {
    const response = await axios.get(`/deudas/${id}`);
    cad.value = response.data;
  } catch (error) {
    console.error(error);
  }
});
</script>

<template>
    <GuestLayout>
        <Head title="Comentarios" />

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="comentario" value="Comentario" />

                <TextInput
                    id="comentario"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.comentario"
                    required
                    autofocus
                    autocomplete="comentario"
                />

                <InputError class="mt-2" :message="form.errors.comentario" />
            </div>

            <!--Este hidden para mandar el usuario autenticado-->
            <input type="hidden" v-model="form.usuario_id"/>

            <!--Este hidden para mandar el id del deudor mostrado en pantalla-->
            <input type="hidden" v-model="form.deudor_id"/>

            <div class="flex items-center justify-end mt-4">
                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Agregar Comentario
                </PrimaryButton>
            </div>
        </form>

        <div class="py-3" v-for="(comentario, id) in cad">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-2 text-gray-900 dark:text-gray-100" :key="id">{{ comentario.created_at }}</div>
                    <div class="p-2 text-gray-900 dark:text-gray-100" :key="id">{{ comentario.comentario }}</div>
                </div>
            </div>
        </div>

    </GuestLayout>
</template>