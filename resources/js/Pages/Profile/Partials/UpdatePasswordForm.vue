<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const passwordInput = ref<HTMLInputElement | null>(null);
const currentPasswordInput = ref<HTMLInputElement | null>(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value?.focus();
            }
            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value?.focus();
            }
        },
    });
};
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Actualizar Contraseña</h2>

            <p class="mt-1 text-sm text-gray-600">
                Asegúrate de que tu cuenta utiliza una contraseña máxima de 10 caracteres.
            </p>
        </header>

        <form @submit.prevent="updatePassword" class="mt-6 space-y-6">

            <div class="lg:col-span-1">
                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6">
                    <div class="md:col-span-6">
                        <InputLabel for="current_password" value="Contraseña Actual" />

                        <TextInput
                            id="current_password"
                            ref="currentPasswordInput"
                            v-model="form.current_password"
                            type="password"
                            class="mt-1 block w-full"
                            autocomplete="current-password"
                            maxlength="10"
                        />

                        <InputError :message="form.errors.current_password" class="mt-2" />
                    </div>
                    <div class="md:col-span-6">
                        <InputLabel for="password" value="Nueva Contraseña" />

                        <TextInput
                            id="password"
                            ref="passwordInput"
                            v-model="form.password"
                            type="password"
                            class="mt-1 block w-full"
                            autocomplete="new-password"
                            maxlength="10"
                        />

                        <InputError :message="form.errors.password" class="mt-2" />
                    </div>
                    <div class="md:col-span-6">
                        <InputLabel for="password_confirmation" value="Confirmar Contraseña" />

                        <TextInput
                            id="password_confirmation"
                            v-model="form.password_confirmation"
                            type="password"
                            class="mt-1 block w-full"
                            autocomplete="new-password"
                            maxlength="10"
                        />

                        <InputError :message="form.errors.password_confirmation" class="mt-2" />
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing" class="bg-blue-950">Guardar</PrimaryButton>

                <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Guardado.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
