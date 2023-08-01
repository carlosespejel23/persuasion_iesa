<script setup lang="ts">
import { ref } from 'vue';
import Dropdown from '@/components/Dropdown.vue';
import DropdownLink from '@/components/DropdownLink.vue';
import NavLink from '@/components/NavLink.vue';
import ResponsiveNavLink from '@/components/ResponsiveNavLink.vue';
import { library } from '@fortawesome/fontawesome-svg-core';
import {faNewspaper, faAddressBook, faIdBadge} from '@fortawesome/free-regular-svg-icons';
import {faUsers, faGear, faHandHoldingDollar, faFileInvoiceDollar} from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
library.add(faNewspaper, faUsers, faGear, faHandHoldingDollar, faAddressBook, faFileInvoiceDollar, faIdBadge);
import { Link, usePage } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);

const user = usePage().props.auth.user;

const selectedImage = ref<string | ArrayBuffer | null>(user.profile_image);
</script>

<style>
.profile-image-container {
  width: 40px; /* Ajusta el tamaño según tus necesidades */
  height: 40px; /* Ajusta el tamaño según tus necesidades */
  border-radius: 50%;
  overflow: hidden;
}

.profile-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
}
</style>

<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <nav class="border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('dashboard')">
                                    <img src="https://persuacion.000webhostapp.com/logotipo.png" width="100" />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
                                    <h1 class="text-gray-800">Noticias &nbsp&nbsp<font-awesome-icon icon="fa-regular fa-newspaper" /></h1>
                                </NavLink>
                                <NavLink :href="route('deudores')" :active="route().current('deudores')">
                                    <h1 class="text-gray-800">Deudores&nbsp&nbsp<font-awesome-icon icon="fa-regular fa-id-badge" /></h1>
                                </NavLink>
                                <NavLink :href="route('deudas')" :active="route().current('deudas')">
                                    <h1 class="text-gray-800">Deudas&nbsp&nbsp<font-awesome-icon icon="fa-solid fa-file-invoice-dollar" /></h1>
                                </NavLink>
                                <NavLink :href="route('pagos')" :active="route().current('pagos')">
                                    <h1 class="text-gray-800">Pagos&nbsp&nbsp<font-awesome-icon icon="hand-holding-dollar" /></h1>
                                </NavLink>
                                <NavLink :href="`/configuracion`" :active="route().current('configuracion.edit')">
                                    <h1 class="text-gray-800">Configuración&nbsp&nbsp<font-awesome-icon icon="gear" /></h1>
                                </NavLink>
                                <NavLink :href="route('personas')" :active="route().current('personas')">
                                    <h1 class="text-gray-800">Personas&nbsp&nbsp<font-awesome-icon icon="users" /></h1>
                                </NavLink>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <!-- Settings Dropdown -->
                            <div class="ml-3 relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-800 bg-gray-100 hover:text-gray-500 focus:outline-none transition ease-in-out duration-150"
                                            >
                                            <div class="profile-image-container">
                                                <img :src="selectedImage" class="profile-image" />
                                            </div> &nbsp;&nbsp;
                                                {{ $page.props.auth.user.nombre }} {{ $page.props.auth.user.apellidoPaterno }} {{ $page.props.auth.user.apellidoMaterno }}

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
                                        <DropdownLink :href="route('profile.edit')"> Perfil </DropdownLink>
                                        <DropdownLink :href="route('noticias')"> Mis Noticias </DropdownLink>
                                        <DropdownLink :href="route('logout')" method="post" as="button">
                                            Finalizar Sesión
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button
                                @click="showingNavigationDropdown = !showingNavigationDropdown"
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                            >
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex': !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex': showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div
                    :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"
                    class="sm:hidden"
                >
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                            <h1 class="text-gray-800">Noticias &nbsp&nbsp<font-awesome-icon icon="fa-regular fa-newspaper" /></h1>
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('deudores')" :active="route().current('deudores')">
                            <h1 class="text-gray-800">Deudores&nbsp&nbsp<font-awesome-icon icon="fa-regular fa-id-badge" /></h1>
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('deudas')" :active="route().current('deudas')">
                            <h1 class="text-gray-800">Deudas&nbsp&nbsp<font-awesome-icon icon="fa-solid fa-file-invoice-dollar" /></h1>
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('pagos')" :active="route().current('pagos')">
                            <h1 class="text-gray-800">Pagos&nbsp&nbsp<font-awesome-icon icon="hand-holding-dollar" /></h1>
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="`/configuracion`" :active="route().current('configuracion.edit')">
                            <h1 class="text-gray-800">Configuración&nbsp&nbsp<font-awesome-icon icon="gear" /></h1>
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('personas')" :active="route().current('personas')">
                            <h1 class="text-gray-800">Personas&nbsp&nbsp<font-awesome-icon icon="users" /></h1>
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="px-4">
                            <div class="font-medium text-base text-gray-800">
                                {{ $page.props.auth.user.nombre }}
                            </div>
                            <div class="font-medium text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.edit')"> <h1 class="text-gray-800">Perfil</h1> </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('noticias')"> <h1 class="text-gray-800">Mis Noticias</h1> </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                                <h1 class="text-gray-800">Finalizar Sesión</h1>
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-blue-950 shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main class="bg-gray-100">
                <slot />
            </main>
        </div>
    </div>
</template>
