<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { EmojiConfig } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import axios from 'axios';
import { ref, onMounted, defineProps, computed } from 'vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { usePage } from '@inertiajs/vue3';

//Actualiza el nombre de los emojis
const page = usePage();
const emoji = ref<EmojiConfig | null>(page.props.emoji_config as EmojiConfig || null);

const form = useForm({
    like: emoji.value ? emoji.value.like : '', // Asigna una cadena vacía como valor predeterminado en lugar de null
    enojo: emoji.value ? emoji.value.enojo : '',
    comentar: emoji.value ? emoji.value.comentar : '',
    compartir: emoji.value ? emoji.value.compartir : '',
});

const submit = () => {
    form.patch(route('configuracion.update', { id: emoji.value.id }));
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Seccion de Configuración</h2>
        </template>

        <!--Aqui va el componente de la noticia, nomas le das formato-->
        <div class="py-3">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <form @submit.prevent="submit">
                    <div class="p-2 text-gray-900 dark:text-gray-100">
                        <p>En esta sección tú puedes cambiar el nombre de tu reacción, porque tú tienes el control</p>
                    </div>

                    <div>
                        <!--El InputLabel lo remplazas por la imagen-->
                        <InputLabel for="like" value="Img de Like" />

                        <TextInput
                            id="like"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.like"
                            :value="form.like"
                            required
                            autofocus
                            autocomplete="like"
                        />

                        <InputError class="mt-2" :message="form.errors.like" />
                    </div>

                    <div>
                        <!--El InputLabel lo remplazas por la imagen-->
                        <InputLabel for="enojo" value="Img de Me Enoja" />

                        <TextInput
                            id="enojo"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.enojo"
                            :value="form.enojo"
                            required
                            autofocus
                            autocomplete="enojo"
                        />

                        <InputError class="mt-2" :message="form.errors.enojo" />
                    </div>

                    <div>
                        <!--El InputLabel lo remplazas por la imagen-->
                        <InputLabel for="comentar" value="Img de Comentar" />

                        <TextInput
                            id="comentar"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.comentar"
                            :value="form.comentar"
                            required
                            autofocus
                            autocomplete="comentar"
                        />

                        <InputError class="mt-2" :message="form.errors.comentar" />
                    </div>

                    <div>
                        <!--El InputLabel lo remplazas por la imagen-->
                        <InputLabel for="compartir" value="Img de Compartir" />

                        <TextInput
                            id="compartir"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.compartir"
                            :value="form.compartir"
                            required
                            autofocus
                            autocomplete="compartir"
                        />

                        <InputError class="mt-2" :message="form.errors.compartir" />
                    </div>

                    <div class="flex items-center gap-4">
                        <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                        <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
                            <p v-if="form.recentlySuccessful" class="text-sm text-gray-600 dark:text-gray-400">Saved.</p>
                        </Transition>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>