<script setup lang="ts">
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';
import axios from 'axios';

const confirmingUserDeletion = ref(false);
const passwordInput = ref<HTMLInputElement | null>(null);

const form = useForm({
    password: '',
});

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value?.focus(),
        onFinish: () => form.reset(),
    });
};

const showConfirmModal = ref(false);
const showErrorModal = ref(false);

const confirmUserDeletion = () => {
    axios.get('/profile/check')
        .then((response) => {
            const emailExists = response.data.emailExists;
            if (emailExists) {
                showErrorModal.value = true;
            } else {
                showConfirmModal.value = true;
                nextTick(() => passwordInput.value?.focus());
            }
        })
        .catch((error) => {
            console.error(error);
        });
};

const closeModal = () => {
    showConfirmModal.value = false;
    showErrorModal.value = false;
    form.reset();
};
</script>

<template>
    <section class="space-y-6">
        <header>
            <h2 class="text-lg font-medium text-gray-900">Eliminar Cuenta</h2>

            <p class="mt-1 text-sm text-gray-600">
                Una vez eliminada su cuenta, todos sus recursos y datos se borrarán permanentemente.
            </p>
        </header>

        <DangerButton @click="confirmUserDeletion">Eliminar Cuenta</DangerButton>

        <!--Ventana modal de eliminar cuenta-->
        <Modal v-if="showConfirmModal" :show="showConfirmModal" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    ¿Está seguro de que desea eliminar su cuenta?
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    Una vez eliminada su cuenta, todos sus recursos y datos se borrarán permanentemente. Por favor, introduzca su contraseña para confirmar que desea eliminar definitivamente su cuenta.
                </p>

                <div class="mt-6">
                    <InputLabel for="password" value="Contraseña" class="sr-only" />

                    <TextInput
                        id="password"
                        ref="passwordInput"
                        v-model="form.password"
                        type="password"
                        class="mt-1 block w-3/4"
                        placeholder="Contraseña"
                        @keyup.enter="deleteUser"
                    />

                    <InputError :message="form.errors.password" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal"> Cancelar </SecondaryButton>

                    <DangerButton
                        class="ml-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteUser"
                    >
                        Eliminar Cuenta
                    </DangerButton>
                </div>
            </div>
        </Modal>

        <!-- Ventana modal de error al eliminar la cuenta-->
        <Modal v-else :show="showErrorModal" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-red-600">
                    Error al eliminar la cuenta
                </h2>
                <p class="mt-1 text-sm text-gray-600">
                    ¡Ups!, no se puede eliminar la cuenta. Tu cuenta esta registrada como un deudor
                </p>
                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal">Cerrar</SecondaryButton>
                </div>
            </div>
        </Modal>
    </section>
</template>
