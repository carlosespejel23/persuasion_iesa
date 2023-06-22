<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Deudor } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import axios from 'axios';
import { ref, onMounted, defineProps, computed } from 'vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { usePage } from '@inertiajs/vue3';

//Actualiza el monto pagado
const page = usePage();
const deudor = ref<Deudor | null>(page.props.deudor as Deudor || null);

const form = useForm({
    monto_pagado: deudor.value ? deudor.value.monto_pagado : null,
});

const submit = () => {
    form.patch(route('pagos.update', { id: deudor.value.id }));
};

// Propiedad computada 'cantidadRestante'
const cantidadRestante = computed(() => {
  if (deudor.value) {
    const montoPagado = parseFloat(form.monto_pagado as unknown as string) || 0;
    const montoAPagar = deudor.value.monto_a_pagar || 0;
    return montoAPagar - montoPagado;
  }
  return 0;
});

//Comentarios
const redirectToPost = (id: number) => {
  window.location.href = `/pagos/create/${id}`;
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Seccion de Pagos</h2>
        </template>

        <!--Aqui va el componente de la noticia, nomas los acomodas en una tarjeta-->
        <div class="py-3">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <form @submit.prevent="submit">
                    <!--Aqui le pones que el input no rebase la cantidad de pago, obviamente lo pones con el formato de dinero-->
                    <div>
                        <InputLabel for="monto_pagado" value="Monto pagado" />

                        <TextInput
                            id="monto_pagado"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.monto_pagado"
                            :value="form.monto_pagado"
                            required
                            autofocus
                            autocomplete="monto_pagado"
                        />

                        <InputError class="mt-2" :message="form.errors.monto_pagado" />
                    </div>

                    <div class="flex items-center gap-4">
                        <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                        <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
                            <p v-if="form.recentlySuccessful" class="text-sm text-gray-600 dark:text-gray-400">Saved.</p>
                        </Transition>
                    </div>

                    <div class="p-2 text-gray-900 dark:text-gray-100" v-if="cantidadRestante <= 0">
                        <p>Pago completado.</p>
                    </div>
                    <!-- Muestra la cantidad restante cuando no se haya completado el pago -->
                    <div class="p-2 text-gray-900 dark:text-gray-100" v-else>
                        <p>Cantidad restante: ${{ cantidadRestante.toFixed(2) }}</p>
                    </div>

                    <div class="p-2 text-gray-900 dark:text-gray-100">
                        <p>Monto a pagar: ${{ deudor?.monto_a_pagar }}</p>
                    </div>
                </form>
                <a @click="redirectToPost(deudor.id)" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                    Comentarios
                </a>
            </div>
        </div>
    </AuthenticatedLayout>
</template>