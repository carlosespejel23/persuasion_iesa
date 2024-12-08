<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Deudor } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import axios from 'axios';
import { ref, onMounted, defineProps, computed } from 'vue';
import InputError from '@/Components/InputError.vue';
import ButtonNav from '@/components/ButtonNav.vue';
import TextInputPago from '@/components/TextInputPago.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { usePage } from '@inertiajs/vue3';
import { library } from '@fortawesome/fontawesome-svg-core';
import {faComments} from '@fortawesome/free-solid-svg-icons';
import {faCircleCheck} from '@fortawesome/free-regular-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
library.add(faComments, faCircleCheck);

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

<style>
  .facom{
    font-size: 200%;
  }
</style>

<template>
    
    <Head>
        <title>
            Actualizar Pago | Persuasión
        </title>
        <link rel="icon" href="/images/icono.png" type="image/x-icon">
    </Head>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-white leading-tight text-center">
                Sección Actualización de Pagos
            </h2>
        </template>

        <div class="py-3">
            <form @submit.prevent="submit">
                <div class="p-3 bg-gray-100 flex items-center justify-center">
                    <div>
                        <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6 border-2">
                            <div class="flex flex-wrap -mx-3 mb-6">
                                <div class="w-full md:w-full px-3 mb-2 mt-2">

                                    <TextInputPago
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

                                    <br>

                                    <div class="flex items-center gap-4 justify-center">
                                        <PrimaryButton :disabled="form.processing" class="bg-green-400 hover:bg-green-950">Actualizar Pago</PrimaryButton>

                                        <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
                                            <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Cobrado</p>
                                        </Transition>
                                    </div>

                                    <div class="p-2 text-black">
                                        <h2 class="pt-3 pb-2 text-black text-lg text-center">
                                            Cantidad a Pagar
                                        </h2>
                                        <hr>
                                        <h2 class="pt-3 pb-2 text-black text-lg text-center">${{ deudor?.monto_a_pagar }}</h2>
                                    </div>

                                    <div class="text-green-500" v-if="cantidadRestante <= 0">
                                        <h2 class="pt-3 pb-2 text-green text-lg text-center">Pago Completado&nbsp<font-awesome-icon icon="fa-regular fa-circle-check" /></h2>
                                    </div>

                                    <!-- Muestra la cantidad restante cuando no se haya completado el pago -->
                                    <div class="text-black" v-else>
                                        <h2 class="pt-3 pb-2 text-black text-lg text-center">
                                            Cantidad Restante
                                        </h2>
                                        <hr>
                                        <h2 class="pt-3 pb-2 text-black text-lg text-center">${{ cantidadRestante.toFixed(2) }}</h2>
                                    </div>
                                </div>
                            </div>

                            <a @click="redirectToPost(deudor.id)" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <div align="center">
                                    <ButtonNav>
                                        Comentar&nbsp<font-awesome-icon icon="fa-solid fa-comments" />
                                    </ButtonNav>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>