<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import FileInput from '@/Components/FileInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import axios from 'axios';

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
  console.log(file);

  const allowedMimeTypes = ['image/jpeg', 'image/jpg', 'image/png'];
  const fileType = file.type;

  if (!allowedMimeTypes.includes(fileType.toLowerCase())) {
    console.error('El tipo de archivo no está permitido. Solo se aceptan archivos JPEG, JPG o PNG.');
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
    console.error(error);
  }
};

</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Foto de Perfil</h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Update your account's profile photo.
            </p>
        </header>

        <form @submit.prevent="submit" class="mt-6 space-y-6" enctype="multipart/form-data">

            <div>

                <div class="mt-4 card shadow-lg">
                  <div class="card-body py-4">
                      <div class="row">
                        <div class="col-12 col-md-3 px-0 text-center">
                            <img :src="selectedImage" class="align-self-center mb-4 mb-md-0 rounded-square" /> <!--Redondea la img-->
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
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                <!--Aqui quiero que muestres al usuario una ventana modal para que asegure que ya se esta subiendo su foto, porque este 
                componente ya no me sirve. Si puedes arreglarlo, tambien es valido-->

                <!--El componente de aqui abajo es el que no sirve-->

                <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600 dark:text-gray-400">Saved.</p>
                </Transition> 

            </div>
        </form>
    </section>
</template>