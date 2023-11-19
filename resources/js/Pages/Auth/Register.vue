<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import ModalContrato from '@/components/ModalContrato.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Checkbox from '@/Components/Checkbox.vue';
import Dropdown from '@/components/Dropdown.vue';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faUser, faUserPlus, faCircleArrowLeft, faPhone, faLocationDot, faEnvelope } from '@fortawesome/free-solid-svg-icons';
import {faSquareFacebook, faSquareTwitter, faSquareYoutube} from '@fortawesome/free-brands-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { ref } from 'vue';
library.add(faUser, faUserPlus, faCircleArrowLeft, faSquareFacebook, faSquareTwitter, faSquareYoutube, faPhone, faLocationDot, faEnvelope);

const form = useForm({
    nombre: '',
    apellidoPaterno: '',
    apellidoMaterno: '',
    telefono: '',
    fecha_de_nacimiento: '',
    nacionalidad: '',
    acepto_contrato: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
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

<style>
      .smaller-text {
        font-size: 15px;
      }

      .face, .you, .twi{
        font-size: 180%;
      }
</style>

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
            Registro | Persuasión
        </title>
        <link rel="icon" href="/images/icono.png" type="image/x-icon">
    </Head>

    <!--Barra de navegacion-->
    <nav class="bg-blue-950 px-6 relative shadow-md">
        <div class="flex flex-row justify-between items-center py-2">
            <Link href="/"><img src="/images/logob.png" width="100" /></Link>
        </div>
    </nav>

    <!--Aqui empieza el formulario-->
    <form @submit.prevent="submit" class="px-8 pt-6 mb-4 rounded w-full xl:w-3/4 lg:w-12/12 mx-auto">

        <div class="bg-white shadow-md rounded border-2 px-8 pt-6 pb-8 mb-4 flex flex-col my-2">

            <div class="mb-4">
                <h3 class="pt-4 text-4xl text-center"><b>Registro Nuevo Usuario</b></h3>
            </div>

            <hr>
            <br>

            <div class="-mx-3 md:flex">

                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <!--Input de Nombre-->
                    <div class="mb-4">
                        <InputLabel for="nombre" value="Nombre" />

                        <TextInput
                            id="nombre"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.nombre"
                            required
                            autofocus
                            autocomplete="nombre"
                        />

                        <InputError class="mt-2" :message="form.errors.nombre" />
                    </div>
                </div>

                <div class="md:w-1/2 px-3">
                    <!--Input de Apellido Paterno-->
                    <div class="mb-4">
                        <InputLabel for="apellidoPaterno" value="Apellido Paterno" />

                        <TextInput
                            id="apellidoPaterno"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.apellidoPaterno"
                            required
                            autofocus
                            autocomplete="apellidoPaterno"
                        />

                        <InputError class="mt-2" :message="form.errors.apellidoPaterno" />
                    </div>
                </div>
                
            </div>

            <div class="-mx-3 md:flex">

                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <!--Input de Apellido Materno-->
                    <div class="mb-4">
                        <InputLabel for="apellidoMaterno" value="Apellido Materno" />

                        <TextInput
                            id="apellidoMaterno"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.apellidoMaterno"
                            required
                            autofocus
                            autocomplete="apellidoMaterno"
                        />

                        <InputError class="mt-2" :message="form.errors.apellidoMaterno" />
                    </div>
                </div>

                <div class="md:w-1/2 px-3">
                    <!--Input de Telefono-->
                    <div class="mb-4">
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
                </div>
            </div>

            <div class="-mx-3 md:flex">

                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <!--Input de Fecha de Nacimiento-->
                    <div class="mb-4">
                        <InputLabel for="fecha_de_nacimiento" value="Fecha de Nacimiento" />

                        <TextInput
                            id="fecha_de_nacimiento"
                            type="date"
                            class="mt-1 block w-full"
                            v-model="form.fecha_de_nacimiento"
                            required
                            autofocus
                            autocomplete="fecha_de_nacimiento"
                        />

                        <InputError class="mt-2" :message="form.errors.fecha_de_nacimiento" />
                    </div>
                </div>

                <div class="md:w-1/2 px-3">
                    <!--Input de Email-->
                    <div class="mb-4">
                        <InputLabel for="email" value="Correo Electrónico" />

                        <TextInput
                            id="email"
                            type="email"
                            class="mt-1 block w-full"
                            v-model="form.email"
                            required
                            placeholder="usuario@gmail.com"
                            autocomplete="username"
                        />

                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>
                </div>
            </div>

            <div class="-mx-3 md:flex">

                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <!--Input de Password-->
                    <div class="mb-4">
                        <InputLabel for="password" value="Contraseña" />

                        <TextInput
                            id="password"
                            type="password"
                            class="mt-1 block w-full"
                            v-model="form.password"
                            required
                            autocomplete="new-password"
                        />

                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>
                </div>

                <div class="md:w-1/2 px-3">
                    <!--Input de Confirm Password-->
                    <div class="mb-4">
                        <InputLabel for="password_confirmation" value="Confirmar Contraseña" />

                        <TextInput
                            id="password_confirmation"
                            type="password"
                            class="mt-1 block w-full"
                            v-model="form.password_confirmation"
                            required
                            autocomplete="new-password"
                        />

                        <InputError class="mt-2" :message="form.errors.password_confirmation" />
                    </div>
                </div>
            </div>

            <div class="-mx-3 md:flex">

                <Dropdown align="left" width="48" v-model="form.nacionalidad" required>
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
                <InputError class="mt-2" :message="form.errors.nacionalidad" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                <!--Checkbox de contrato-->
                <div class="mb-4">
                    <Checkbox
                        id="acepto_contrato"
                        v-model="form.acepto_contrato"
                        name="acepto_contrato"
                        value=1
                        unchecked-value=0
                    ></Checkbox>
                    <span>&nbsp&nbsp<ModalContrato /><strong style="visibility:hidden;">{{ form.acepto_contrato }}</strong></span>
                        
                    <InputError class="mt-2" :message="form.errors.acepto_contrato" />
                </div>
            </div>

            <!--Button de Registro Acceso-->
            <div class="mb-4" align="right">
                <Link
                    :href="route('login')"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    ¿Ya tienes Cuenta?
                </Link>
                <PrimaryButton class="ml-4 bg-blue-950" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Registrarse
                </PrimaryButton>
            </div> 
        </div>
    </form>

    <!-- Footer -->
    <footer class="bg-blue-950">

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