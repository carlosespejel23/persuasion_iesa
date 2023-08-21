<script setup lang="ts">
import GuestLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInputPrice from '@/components/TextInputPrice.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import { defineProps, ref } from 'vue';
import Dropdown from '@/components/Dropdown.vue';
import { library } from '@fortawesome/fontawesome-svg-core';
import {faIdBadge} from '@fortawesome/free-regular-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
library.add(faIdBadge);

defineProps<{
    mustVerifyEmail?: Boolean;
    status?: String;
}>();

const user = usePage().props.auth.user;

const form = useForm({
    usuario_id: user.id,
    nombre: '',
    apellidoPaterno: '',
    apellidoMaterno: '',
    email: '',
    telefono: '',
    nacionalidad: '',
    curp: '',
    rfc: '',
    monto_a_pagar: '',
});

const submit = () => {
    form.post(route('deudores.save'), {
        onFinish: () => form.reset('nombre', 'apellidoPaterno', 'apellidoMaterno', 'email', 'telefono', 'monto_a_pagar'),
    });
};

//Lista de paises para iterar en el componente Dropdown
const nacionalidades = [
  "Afganistán", "Albania", "Alemania", "Andorra", "Angola", "Antigua y Barbuda", "Arabia Saudita", "Argelia", "Argentina", "Armenia", "Australia",
  "Austria", "Azerbaiyán", "Bahamas", "Bangladés", "Barbados", "Baréin", "Bélgica", "Belice", "Benín", "Bielorrusia", "Birmania", "Bolivia",
  "Bosnia y Herzegovina", "Botsuana", "Brasil", "Brunéi", "Bulgaria", "Burkina Faso", "Burundi", "Bután", "Cabo Verde", "Camboya", "Camerún",
  "Canadá", "Catar", "Chad", "Chile", "China", "Chipre", "Ciudad del Vaticano", "Colombia", "Comoras", "Corea del Norte", "Corea del Sur",
  "Costa de Marfil", "Costa Rica", "Croacia", "Cuba", "Dinamarca", "Dominica", "Ecuador", "Egipto", "El Salvador", "Emiratos Árabes Unidos",
  "Eritrea", "Eslovaquia", "Eslovenia", "España", "Estados Unidos", "Estonia", "Etiopía", "Filipinas", "Finlandia", "Fiyi", "Francia", "Gabón",
  "Gambia", "Georgia", "Ghana", "Granada", "Grecia", "Guatemala", "Guyana", "Guinea", "Guinea ecuatorial", "Guinea-Bisáu", "Haití", "Honduras",
  "Hungría", "India", "Indonesia", "Irak", "Irán", "Irlanda", "Islandia", "Islas Marshall", "Islas Salomón", "Israel", "Italia", "Jamaica",
  "Japón", "Jordania", "Kazajistán", "Kenia", "Kirguistán", "Kiribati", "Kuwait", "Laos", "Lesoto", "Letonia", "Líbano", "Liberia", "Libia",
  "Liechtenstein", "Lituania", "Luxemburgo", "Madagascar", "Malasia", "Malaui", "Maldivas", "Malí", "Malta", "Marruecos", "Mauricio", "Mauritania",
  "México", "Micronesia", "Moldavia", "Mónaco", "Mongolia", "Montenegro", "Mozambique", "Namibia", "Nauru", "Nepal", "Nicaragua", "Níger",
  "Nigeria", "Noruega", "Nueva Zelanda", "Omán", "Países Bajos", "Pakistán", "Palaos", "Panamá", "Papúa Nueva Guinea", "Paraguay", "Perú",
  "Polonia", "Portugal", "Reino Unido", "República Centroafricana", "República Checa", "República Democrática del Congo", "República Dominicana",
  "Ruanda", "Rumania", "Rusia", "Samoa", "San Cristóbal y Nieves", "San Marino", "San Vicente y las Granadinas", "Santa Lucía",
  "Santo Tomé y Príncipe", "Senegal", "Serbia", "Seychelles", "Sierra Leona", "Singapur", "Siria", "Somalia", "Sri Lanka", "Suazilandia",
  "Sudáfrica", "Sudán", "Sudán del Sur", "Suecia", "Suiza", "Surinam", "Tailandia", "Tanzania", "Tayikistán", "Timor Oriental", "Togo",
  "Tonga", "Trinidad y Tobago", "Túnez", "Turkmenistán", "Turquía", "Tuvalu", "Ucrania", "Uganda", "Uruguay", "Uzbekistán", "Vanuatu",
  "Venezuela", "Vietnam", "Yemen", "Yibuti", "Zambia", "Zimbabue",
];
</script>

<style scoped>
.dropdown-options {
  max-height: 150px; /* Establece la altura máxima deseada */
  overflow-y: auto; /* Agrega una barra de desplazamiento vertical si es necesario */
  border: 1px solid #ccc; /* Agrega un borde para separar visualmente las opciones */
}
</style>

<template>
    
    <Head>
        <title>
            Nuevo Deudor | Persuasión
        </title>
        <link rel="icon" href="/images/icono.png" type="image/x-icon">
    </Head>

    <GuestLayout>
        <form @submit.prevent="submit">

            <div class="p-6 bg-white flex items-center justify-center">

                <div class="container max-w-screen-lg mx-auto">

                    <div>

                        <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6 border-2">

                            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-2">

                                <div class="lg:col-span-2">

                                    <center><img src="/images/deu.png" width="150" /></center>
                                    <h2 class="font-semibold text-xl text-gray-600 mb-6 text-center">Agregar Nuevo Deudor</h2>
                                    <hr>
                                    <br>
                                    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6">

                                        <div class="md:col-span-3">
                                            <InputLabel for="nombre" value="Nombre" />

                                            <TextInput
                                                id="nombre"
                                                type="text"
                                                class="mt-1 block w-full"
                                                v-model="form.nombre"
                                                required
                                                autofocus
                                                autocomplete="nombre"
                                                maxlength="50"
                                            />

                                            <InputError class="mt-2" :message="form.errors.nombre" />
                                        </div>

                                        <div class="md:col-span-3">
                                            <InputLabel for="apellidoPaterno" value="Apellido Paterno" />

                                            <TextInput
                                                id="apellidoPaterno"
                                                type="text"
                                                class="mt-1 block w-full"
                                                v-model="form.apellidoPaterno"
                                                required
                                                autofocus
                                                autocomplete="apellidoPaterno"
                                                maxlength="50"
                                            />

                                            <InputError class="mt-2" :message="form.errors.apellidoPaterno" />
                                        </div>

                                        <div class="md:col-span-3">
                                            <InputLabel for="apellidoMaterno" value="Apellido Materno" />

                                            <TextInput
                                                id="apellidoMaterno"
                                                type="text"
                                                class="mt-1 block w-full"
                                                v-model="form.apellidoMaterno"
                                                required
                                                autofocus
                                                autocomplete="apellidoMaterno"
                                                maxlength="50"
                                            />

                                            <InputError class="mt-2" :message="form.errors.apellidoMaterno" />
                                        </div>

                                        <div class="md:col-span-3">
                                            <InputLabel for="telefono" value="Teléfono" />

                                            <TextInput
                                                id="telefono"
                                                type="text"
                                                class="mt-1 block w-full"
                                                v-model="form.telefono"
                                                required
                                                autofocus
                                                autocomplete="telefono"
                                                maxlength="10" 
                                                pattern="[0-9]+"
                                            />

                                            <InputError class="mt-2" :message="form.errors.telefono" />
                                        </div>

                                        <div class="md:col-span-3">
                                            <InputLabel for="curp" value="CURP (Clave Única de Registro de Población) - Opcional" />

                                            <TextInput
                                                id="curp"
                                                type="text"
                                                class="mt-1 block w-full"
                                                v-model="form.curp"
                                                autocomplete="curp"
                                                minlength="18"
                                                maxlength="18"
                                                @input="form.curp = $event.target.value.toUpperCase()"
                                            />

                                            <InputError class="mt-2" :message="form.errors.curp" />
                                        </div>

                                        <div class="md:col-span-3">
                                            <InputLabel for="rfc" value="RFC (Registro Federal de Contribuyentes) - Opcional" />

                                            <TextInput
                                                id="rfc"
                                                type="text"
                                                class="mt-1 block w-full"
                                                v-model="form.rfc"
                                                autocomplete="rfc"
                                                minlength="13"
                                                maxlength="13"
                                                @input="form.rfc = $event.target.value.toUpperCase()"
                                            />

                                            <InputError class="mt-2" :message="form.errors.rfc" />
                                        </div>

                                        <div class="md:col-span-3">
                                            <InputLabel for="email" value="Correo Electrónico" />

                                            <TextInput
                                                id="email"
                                                type="email"
                                                class="mt-1 block w-full"
                                                v-model="form.email"
                                                required
                                                autocomplete="email"
                                                maxlength="60"
                                            />

                                            <InputError class="mt-2" :message="form.errors.email" />
                                        </div>

                                        <div class="md:col-span-3">

                                            <TextInputPrice
                                                id="monto_a_pagar"
                                                type="text"
                                                class="mt-1 block w-full"
                                                v-model="form.monto_a_pagar"
                                                required
                                                autofocus
                                                autocomplete="monto_a_pagar"
                                            />

                                            <InputError class="mt-2" :message="form.errors.monto_a_pagar" />
                                        </div>

                                        <div class="md:col-span-3"></div>

                                        <div class="md:col-span-3 text-end">
                                            <Dropdown align="right" width="48" v-model="form.nacionalidad" required>
                                                <template #trigger>
                                                    <span class="inline-flex rounded-md">
                                                        <button
                                                            type="button"
                                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-800 bg-gray-100 hover:text-gray-500 focus:outline-none transition ease-in-out duration-150"
                                                        >

                                                        <InputLabel for="nacionalidad" value="Nacionalidad: " /> &nbsp;&nbsp;{{ form.nacionalidad }}
                                                            <svg
                                                                class="ml-2 -mr-0.5 h-4 w-4"
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                viewBox="0 0 20 20"
                                                                fill="currentColor"
                                                            >
                                                                <path
                                                                    fill-rule="evenodd"
                                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                                    clip-rule="evenodd"
                                                                />
                                                            </svg>
                                                        </button>
                                                    </span>
                                                </template>

                                                <template #content>
                                                    <div class="dropdown-options">
                                                        <option @click="form.nacionalidad = nacionalidad" v-for="nacionalidad in nacionalidades" :key="nacionalidad" class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-300 hover:bg-gray-800 focus:outline-none focus:bg-gray-800 transition duration-150 ease-in-out">
                                                            {{ nacionalidad }}
                                                        </option>
                                                    </div>
                                                </template>
                                            </Dropdown>
                                            <InputError class="mt-2" :message="form.errors.nacionalidad" />
                                        </div>

                                        <!--Este hidden para mandar el usuario autenticado-->
                                        <input type="hidden" v-model="form.usuario_id"/>
                                        
                                    </div>

                                    <div class="flex items-center justify-end mt-4">
                                        <PrimaryButton class="bg-blue-950" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                            Agregar Deudor
                                        </PrimaryButton>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </GuestLayout>
</template>