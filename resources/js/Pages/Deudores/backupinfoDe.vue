<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Deudor } from '@/types';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import axios from 'axios';
import { ref, onMounted, defineProps } from 'vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

//Esto es para extraer la informacion del deudor
const deudor = ref<Deudor[]>([]);
const uri = new URL(window.location.href);
const id = uri.pathname.split('/').pop();

onMounted(async () => {
  try {
    const response = await axios.get(`/deudores/deudor/show/${id}`);
    deudor.value = response.data;
  } catch (error) {
    console.error(error);
  }
});

//Formulario para agregar el curp y rfc en caso de que el formulario de agregar deudor se haya omitido
const form = useForm({
    curp: '',
    rfc: '',
});

const submit = () => {
    form.post(route('deudores.agregarInfoDeudor', id), {
        onFinish: () => form.reset('curp', 'rfc'),
    });
};
</script>

<template>

    <Head>
      <title>
        Deudor | Persuasión
      </title>
      <link rel="icon" href="/images/icono.png" type="image/x-icon">
    </Head>

    <AuthenticatedLayout>

        <template #header>
            <h1 class="font-semibold text-xl text-white leading-tight mx-auto text-center">
                Información del Deudor
            </h1>
        </template>

        <div class="text-center mx-auto px-10 py-5 sm:px-6 lg:max-w-6xl lg:px-8 bg-gray-100">
            <div class="container max-w-screen-lg mx-auto">
                <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6 border-2">

                    <center><h1 class="font-semibold text-xl text-gray-800 leading-tight mx-auto text-center">{{ deudor[0]?.nombre }} {{ deudor[0]?.apellidoPaterno }} {{ deudor[0]?.apellidoMaterno }}</h1></center>
                    <br>
                    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-2">

                        <div class="lg:col-span-2">
                            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6">

                                <div class="md:col-span-2">
                                    <InputLabel for="telefono" value="Teléfono" />

                                    <TextInput
                                        id="telefono"
                                        type="text"
                                        class="mt-1 block w-full text-center"
                                        :value="deudor[0]?.telefono"
                                        required
                                        autofocus
                                        autocomplete="telefono"
                                        maxlength="10" 
                                        pattern="[0-9]+"
                                        v-bind:disabled="true"
                                    />
                                </div>

                                <div class="md:col-span-2">
                                    <InputLabel for="email" value="Correo Electrónico" />

                                    <TextInput
                                        id="email"
                                        type="email"
                                        class="mt-1 block w-full text-center"
                                        :value="deudor[0]?.email"
                                        required
                                        autocomplete="email"
                                        maxlength="60"
                                        v-bind:disabled="true"
                                    />
                                </div>

                                <div class="md:col-span-2">
                                    <InputLabel for="nacionalidad" value="Nacionalidad" />

                                    <TextInput
                                        id="nacionalidad"
                                        type="text"
                                        class="mt-1 block w-full text-center"
                                        :value="deudor[0]?.nacionalidad"
                                        required
                                        autocomplete="nacionalidad"
                                        maxlength="60"
                                        v-bind:disabled="true"
                                    />
                                </div>

                                <div class="md:col-span-3">
                                    <InputLabel for="monto_a_pagar" value="Monto a Pagar" />

                                    <TextInput
                                        id="monto_a_pagar"
                                        type="text"
                                        class="mt-1 block w-full text-center"
                                        :value="'$' + ' ' + deudor[0]?.monto_a_pagar"
                                        required
                                        autofocus
                                        autocomplete="monto_a_pagar"
                                        disabled="true"
                                    />
                                </div>

                                <div class="md:col-span-3">
                                    <InputLabel for="monto_pagado" value="Monto Pagado" />

                                    <TextInput
                                        id="monto_pagado"
                                        type="text"
                                        class="mt-1 block w-full text-center"
                                        :value="'$' + ' ' + deudor[0]?.monto_pagado"
                                        required
                                        autofocus
                                        autocomplete="monto_a_pagar"
                                        disabled="true"
                                    />
                                </div>

                                <!--(!deudor[0]?.curp && !deudor[0]?.rfc) || deudor[0]?.curp === null-->
                                <div v-if="((deudor[0]?.curp === null || deudor[0]?.curp === '' || deudor[0]?.curp != null) && (deudor[0]?.rfc === null || deudor[0]?.rfc === '')) || ((deudor[0]?.curp === null || deudor[0]?.curp === '') && (deudor[0]?.rfc === null || deudor[0]?.rfc === ''  || deudor[0]?.rfc != null))" class="md:col-span-6">
                                    <form @submit.prevent="submit">
                                        <div class="mb-4">
                                            <InputLabel for="curp" value="CURP (Clave Única de Registro de Población) - Opcional" />

                                            <TextInput
                                                id="curp"
                                                type="text"
                                                class="mt-1 block w-full text-center"
                                                v-model="form.curp"
                                                :value="form.curp || deudor[0]?.curp"
                                                autocomplete="curp"
                                                minlength="18"
                                                maxlength="18"
                                                required
                                                autofocus
                                                @input="form.curp = $event.target.value.toUpperCase()"
                                            />

                                            <InputError class="mt-2" :message="form.errors.curp" />
                                        </div>

                                        <div class="mb-4">
                                            <InputLabel for="rfc" value="RFC (Registro Federal de Contribuyentes) - Opcional" />

                                            <TextInput
                                                id="rfc"
                                                type="text"
                                                class="mt-1 block w-full text-center"
                                                v-model="form.rfc"
                                                :value="form.rfc  || deudor[0]?.rfc"
                                                autocomplete="rfc"
                                                minlength="13"
                                                maxlength="13"
                                                required
                                                autofocus
                                                @input="form.rfc = $event.target.value.toUpperCase()"
                                            />

                                            <InputError class="mt-2" :message="form.errors.rfc" />
                                        </div>

                                        <div class="flex items-center justify-end mt-4">
                                            <PrimaryButton class="bg-blue-950" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                                Agregar Información
                                            </PrimaryButton>
                                        </div><br>

                                        <div style="background-color: #e42c2c; padding: 3px 7px; border: none; border-radius: 4px; color: white;">
                                            <h1>Nota: Una vez hayas almacenado el CURP y RFC no podrás modificar ambos datos.</h1>
                                        </div>
                                    </form>
                                </div>

                                <div v-else class="md:col-span-6">
                                    <InputLabel for="curp" value="CURP (Clave Única de Registro de Población)" />

                                    <TextInput
                                        id="curp"
                                        type="text"
                                        class="mt-1 block w-full text-center"
                                        :value="deudor[0]?.curp"
                                        autocomplete="curp"
                                        minlength="18"
                                        maxlength="18"
                                        v-bind:disabled="true"
                                    /> <br>

                                    <InputLabel for="rfc" value="RFC (Registro Federal de Contribuyentes)" />

                                    <TextInput
                                        id="rfc"
                                        type="text"
                                        class="mt-1 block w-full text-center"
                                        :value="deudor[0]?.rfc"
                                        autocomplete="rfc"
                                        minlength="13"
                                        maxlength="13"
                                        v-bind:disabled="true"
                                    />
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
        
    </AuthenticatedLayout>
</template>