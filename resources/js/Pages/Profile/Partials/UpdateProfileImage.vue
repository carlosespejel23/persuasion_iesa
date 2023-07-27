<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import FileInput from '@/Components/FileInput.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import axios from 'axios';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

defineProps<{
    mustVerifyEmail?: Boolean;
    status?: String;
    form: {
        profile_image: File | null;
    };
}>();

const user = usePage().props.auth.user;

//Formulario de Foto de Perfil
const form = useForm({
    profile_image: user.profile_image,
});

const formData = new FormData();

const handleProfileImageChange = (event: { target: { files: any[]; }; }) => {
  const file = event.target.files[0];

  const allowedMimeTypes = ['image/jpeg', 'image/jpg', 'image/png'];
  const fileType = file.type;

  if (!allowedMimeTypes.includes(fileType.toLowerCase())) {
    return;
  }

  formData.append('profile_image', file);

  form.profile_image = file;
};

const selectedImage = ref<string | ArrayBuffer | null>(user.profile_image);

watch<File | string | ArrayBuffer | null>(
  () => form.profile_image,
  (newValue) => {
    if (typeof newValue === 'string') {
      selectedImage.value = removeStoragePath(newValue);
    } else if (newValue instanceof ArrayBuffer) {
      selectedImage.value = URL.createObjectURL(new Blob([newValue]));
    } else if (newValue instanceof File) {
      const reader = new FileReader();
      reader.onload = () => {
        selectedImage.value = reader.result;
      };
      reader.readAsDataURL(newValue);
    } else {
      selectedImage.value = null;
    }
  }
);

const removeStoragePath = (imageUrl: string): string => {
  return imageUrl.replace('/storage', '');
};


const submit = async () => {
  try {
    await axios.post('/profile/photo', formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
    });

  } catch (error) {
  }
};

// Estado de las ventanas modales
const showModalEmpty = ref(false);
const showModalUploaded = ref(false);

// Función para manejar el clic en el botón de guardar
const handleSaveClick = () => {
  if (form.profile_image !== null && Object.keys(form.profile_image).length !== 0) {
    // Mostrar la ventana modal de "¡Ups, no has seleccionado nada! :("
    showModalEmpty.value = true;
  } else {
    // Mostrar la ventana modal de "Ya está subiendo tu nueva foto de perfil"
    showModalUploaded.value = true;
  }
};

// Funciones para cerrar las ventanas modales
const closeModalEmpty = () => {
  showModalEmpty.value = false;
};

const closeModalUploaded = () => {
  showModalUploaded.value = false;
};
</script>

<style>
.div-container {
  max-width: 300px;
  height: 300px; /* Puedes ajustar la altura según tus necesidades */
}

.profile-image-containers {
  width: 300px; /* Ajusta el tamaño según tus necesidades */
  height: 300px; /* Ajusta el tamaño según tus necesidades */
  border-radius: 50%;
  overflow: hidden;
}

.profile-images {
  width: 100%;
  height: 100%;
  object-fit: cover;
}
</style>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Foto de Perfil</h2>

            <p class="mt-1 text-sm text-gray-600">
              Actualiza la foto de perfil de tu cuenta.
            </p>
        </header>

        <form @submit.prevent="submit" class="mt-6 space-y-6" enctype="multipart/form-data">

            <div>

              <div class="mt-4 card">
                <div class="py-4">
                  <div class="d-flex justify-content-center align-items-center div-container">
                    <div class="profile-image-containers">
                      <img :src="selectedImage" class="profile-images" />
                    </div>
                  </div>
                </div>
              </div>

                <InputLabel for="profile_image" />

                <FileInput
                  id="profile_image"
                  label="Seleccionar imagen"
                  type="file"
                  class="mt-1 block w-full"
                  :modelValue="form.profile_image"
                  @update:modelValue="form.profile_image = $event"
                  @change="handleProfileImageChange($event)"
                  :required="true"
                  accept=".jpeg,.jpg,.png"
                ></FileInput>

                <InputError class="mt-2" :message="form.errors.profile_image" />
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing"  @click="handleSaveClick" style="cursor: pointer;">Guardar</PrimaryButton>
            </div>

            <!-- Ventana modal 1: Cuando el input está vacío -->
            <Modal :show="showModalEmpty" @close="closeModalEmpty">
              <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                  ¡Ups, no has seleccionado nada! :(
                </h2>
                <p class="mt-1 text-sm text-gray-600">
                  Selecciona una foto de perfil válida.
                </p>
                <div class="mt-6 flex justify-end">
                  <SecondaryButton @click="closeModalEmpty">Cerrar</SecondaryButton>
                </div>
              </div>
            </Modal>

            <!-- Ventana modal 2: Cuando ya hay una foto cargada -->
            <Modal :show="showModalUploaded" @close="closeModalUploaded">
              <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                  ¡Excelente!
                </h2>
                <p class="mt-1 text-sm text-gray-600">
                  Ya estás subiendo tu nueva foto de perfil.
                </p>
                <div class="mt-6 flex justify-end">
                  <SecondaryButton @click="closeModalUploaded">Cerrar</SecondaryButton>
                </div>
              </div>
            </Modal>

        </form>
    </section>
</template>