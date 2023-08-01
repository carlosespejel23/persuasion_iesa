<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import UpdateProfileImage from './Partials/UpdateProfileImage.vue';
import { Head } from '@inertiajs/vue3';
import axios from 'axios';

defineProps<{
    mustVerifyEmail?: boolean;
    status?: string;
}>();
</script>

<template>
    <Head>
        <title>
            Mi Perfil | Persuación
        </title>
    </Head>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-white leading-tight text-center">Mi Perfil</h2>
        </template>

        <div class="py-12 px-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                
                <div class="p-4 sm:p-8 bg-white shadow rounded sm:rounded-lg">
                    <center><UpdateProfileImage class="max-w-xl" /></center>
                </div>

                <div class="grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 xl:gap-x-8">
                    <div class="p-4 sm:p-8 bg-white shadow rounded sm:rounded-lg">
                        <UpdateProfileInformationForm
                            :must-verify-email="mustVerifyEmail"
                            :status="status"
                            class="max-w-xl"
                        />
                    </div>

                    <div class="p-4 sm:p-8 bg-white shadow rounded sm:rounded-lg">
                        <UpdatePasswordForm class="max-w-xl" />
                    </div>
                </div>

                <div class="p-4 sm:p-8 bg-white shadow rounded sm:rounded-lg">
                    <DeleteUserForm class="max-w-xl" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
