<script setup lang="ts">
import GuestLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { Comentarios } from '@/types';
import axios from 'axios';
import { ref, onMounted, defineProps } from 'vue';
import { format, differenceInSeconds, differenceInMinutes, differenceInHours, differenceInDays } from 'date-fns';

defineProps<{
    mustVerifyEmail?: Boolean;
    status?: String;
}>();

const url = new URL(window.location.href);
const postsId = url.pathname.split('/').pop();

const user = usePage().props.auth.user;

const form = useForm({
    usuarios_id: user.id,
    posts_id: postsId,
    contenido: '',
});

const submit = () => {
    form.post(route('dashboard.saveComment'), {
        onFinish: () => form.reset('contenido'),
    });
};

//Esto es para extraer los comentarios
const comentarios = ref<Comentarios[]>([]);
const uri = new URL(window.location.href);
const noticia = uri.pathname.split('/').pop();

onMounted(async () => {
  try {
    const response = await axios.get(`/dashboard/${noticia}`);
    comentarios.value = response.data;
  } catch (error) {
    console.error(error);
  }
});

// Función para formatear la diferencia de tiempo desde que se publicó el post
const formatTimeSincePublished = (dateString: string) => {
  const currentDate = new Date();
  const postDate = new Date(dateString);
  const secondsDifference = differenceInSeconds(currentDate, postDate);

  if (secondsDifference < 60) {
    return `${secondsDifference}s`;
  } else {
    const minutesDifference = differenceInMinutes(currentDate, postDate);

    if (minutesDifference < 60) {
      return `${minutesDifference}min`;
    } else {
      const hoursDifference = differenceInHours(currentDate, postDate);

      if (hoursDifference < 24) {
        return `${hoursDifference}h`;
      } else {
        const daysDifference = differenceInDays(currentDate, postDate);
        return `${daysDifference}d`;
      }
    }
  }
};
</script>

<template>
    <GuestLayout>
        <Head title="Comentarios" /><br>

        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <form @submit.prevent="submit">
                <div>
                    <InputLabel for="contenido" value="Comentario" />

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

                <!--Este hidden para mandar el usuario autenticado-->
                <input type="hidden" v-model="form.usuarios_id"/>

                <!--Este hidden para mandar el id del deudor mostrado en pantalla-->
                <input type="hidden" v-model="form.posts_id"/>

                <div class="flex items-center justify-end mt-4">
                    <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Agregar Comentario
                    </PrimaryButton>
                </div>
            </form>
        </div>

        <div class="py-3" v-for="(comentario, id) in comentarios">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex">

                    <!-- Fotografía de perfil -->
                    <div class="p-2">
                        <div class="profile-image-container">
                            <img :src="comentario.profile_image" class="profile-image" />
                        </div>
                    </div>

                    <div class="flex-1">
                        <div class="flex items-center"> <!-- Utilizamos flex para alinear el nombre y la fecha horizontalmente -->
                            <div class="p-2 text-gray-900 font-semibold">{{ comentario.nombre }} {{ comentario.apellidoPaterno }} {{ comentario.apellidoMaterno }} &nbsp;&nbsp;·</div>
                            <div class="text-sm text-gray-600 ml-1">{{ formatTimeSincePublished(comentario.created_at) }}</div>
                        </div>
                        <div class=" text-gray-900">&nbsp;&nbsp;{{ comentario.contenido }}</div><br>
                    </div>
                </div>
            </div>
        </div>

    </GuestLayout>
</template>