<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Noticia } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import axios from 'axios';
import { ref, onMounted, defineProps } from 'vue';
import ReactionsComponent from '@/components/ReactionsComponent.vue';

interface ReactionSummary {
  [key: string]: number;
}

//Esto es para extraer las noticias
const item = ref<Noticia[]>([]);

onMounted(async () => {
  try {
    const response = await axios.get('/dashboard/showAll');
    item.value = response.data;
  } catch (error) {
    console.error(error);
  }
});

//Esto es para mandar la URL de cada noticia a los comentarios
const redirectToPost = (id: number) => {
  window.location.href = `/dashboard/show/${id}`;
};

//Esta parte es para las reacciones, ESTA ES UNA PRUEBA
const props = defineProps({
  reacted: {
    type: Object,
    required: false,
  },
});

const types = ["like", "dislike"];
const reactions_summary = ref<ReactionSummary>({ ...(props.reacted ? props.reacted.summary : {}) });
const auth_reaction = ref(props.reacted ? props.reacted.type : null);
const show_reaction_types = ref(false);

function image(type: string) {
  return `.../reactions_${type}.png`; // Ruta real de las imágenes
}

function toggleReaction(reaction: string) {
  let path = window.location.href;
  let old_reaction = auth_reaction.value;

  if (typeof reaction === 'string') {
    axios.post(`${path}`, { reaction }).catch(() => {
      saveReaction(old_reaction, reaction);
    });

    show_reaction_types.value = false;
    saveReaction(reaction, old_reaction);
  }
}

function saveReaction(new_reaction: string, old_reaction: string) {
  resetReactionsSummary(new_reaction, old_reaction);

  if (auth_reaction.value === new_reaction) {
    auth_reaction.value = null;
    return;
  }

  auth_reaction.value = new_reaction;
}

function resetReactionsSummary(new_reaction: string, old_reaction: string) {
  if (old_reaction) {
    reactions_summary.value[old_reaction]--;
  }

  if (new_reaction && new_reaction !== old_reaction) {
    if (!reactions_summary.value[new_reaction]) {
      reactions_summary.value[new_reaction] = 1;
      return;
    }

    reactions_summary.value[new_reaction]++;
  }
}
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Seccion de Noticias</h2>
        </template>

        <!--Aqui le pones el boton a la vista de crear noticia con la ruta: route('dashboard.create'), ahorita nomas esta como link-->
        <div class="flex items-center mt-4">
            <Link
                :href="route('dashboard.create')"
                class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
            >
                Crear Noticia
            </Link>
        </div>

        <!--Aqui va el componente de la noticia, nomas los acomodas en una tarjeta-->
        <div class="py-3" v-for="(noticia, id) in item">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <!--Aqui se hace un IF, si el usuario seleciono que el post sea anonimo remplazas el nombre por "anonimo"-->
                    <div class="p-2 text-gray-900 dark:text-gray-100" :key="id">{{ noticia.nombre }} {{ noticia.apellidoPaterno }} {{ noticia.apellidoMaterno }}</div>
                    <!--Aqui termina el IF-->

                    <!--Aqui solo das formato a la fecha-->
                    <div class="p-2 text-gray-900 dark:text-gray-100" :key="id">{{ noticia.created_at }}</div>
                    <div class="p-2 text-gray-900 dark:text-gray-100" :key="id">{{ noticia.contenido }}</div>
                    <!--Aqui le pones un boton o algo que quiera para que vea los comentarios, este solo es para direcionar la pagina-->
                    <!--El contenido de la etiqueta es un ejemplo, a mi no me sirve routerlink-->
                    <a @click="redirectToPost(noticia.id)" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                        Comentarios
                    </a>

                    <!--Aqui van las reacciones, esta es la prueba FrontEnd-->
                    <!--<div class="mt-3 d-flex">
                      <div
                        class="px-1"
                        v-for="(count, reaction) in reactions_summary"
                        :key="reaction"
                        v-show="count"
                      >
                      <img style="width: 20px" :src="image(String(reaction))" />
                        <span class="px-1">{{ count }}</span>
                      </div>
                    </div>

                    <div class="border-top position-relative">
                      <div
                        class="bg-white border rounded shadow-sm position-absolute"
                        style="bottom: 40px"
                        v-show="show_reaction_types"
                      >
                        <button
                          @click="toggleReaction(type)"
                          class="btn bg-light"
                          v-for="type in types"
                          :key="type"
                        >
                          <img :src="image(type)" />
                        </button>
                      </div>

                      <button
                        @click="show_reaction_types = !show_reaction_types"
                        class="btn btn-link"
                      >
                        <span v-if="auth_reaction">
                          <img :src="image(auth_reaction)" class="w-25" />
                          {{ auth_reaction }}
                        </span>
                        <span v-else class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">Like</span>
                      </button>
                    </div>

                    <ReactionsComponent
                      :summary="reactions_summary"
                      v-if="props.reacted"
                      :reacted="props.reacted"
                      @toggleReaction="toggleReaction"
                    ></ReactionsComponent> -->

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
