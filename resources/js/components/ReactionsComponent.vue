<template>
  <div>
    <div>
      <button @click="toggleReaction('like')" class="btn btn-link" :class="{ active: auth_reaction === 'like' }">
        <div class="flex items-center">
          <img :src="likeImageSrc" width="20" />
          <span class="text-sm text-gray-600 ml-1">{{ reactions_summary.like || 0 }}</span>
        </div>
      </button>&nbsp;&nbsp;&nbsp;

      <button @click="toggleReaction('dislike')" class="btn btn-link" :class="{ active: auth_reaction === 'dislike' }">
        <div class="flex items-center">
          <img :src="dislikeImageSrc" width="17" />
          <span class="text-sm text-gray-600 ml-1">{{ reactions_summary.dislike || 0 }}</span>
        </div>
      </button>&nbsp;&nbsp;&nbsp;

      <button @click="redirectToPost(postId)" class="btn btn-link">
        <div class="flex items-center">
          <img src="/images/comentarios.png" width="20">
          <span class="text-sm text-gray-600 ml-1">{{ getCommentsCount() || 0 }}</span>
        </div>
      </button>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  props: ["postId"],
  data() {
    return {
      comments_summary: {},
      reactions_summary: {},
      auth_reaction: null,
      // Esto es para mandar la URL de cada noticia a los comentarios
      redirectToPost : (id) => {
        window.location.href = `/dashboard/show/${id}`;
      }
    };
  },
  mounted() {
    this.fetchReactionsSummary();
    this.fetchCommentsSummary();
  },
  methods: {
    fetchReactionsSummary() {
      let postId = this.postId;
      // Realiza una llamada al backend para obtener el resumen de reacciones del post
      axios
        .get(`/dashboard/${postId}/reactions-summary`)
        .then((response) => {
          this.reactions_summary = response.data.reactions_summary;
          this.auth_reaction = response.data.reacted ? response.data.reacted.type : null;
        })
        .catch((error) => {
          console.error(error);
        });
    },

    fetchCommentsSummary() {
      let postId = this.postId;
      // Realiza una llamada al backend para obtener el resumen de los comentarios del post
      axios
        .get(`/dashboard/${postId}/comments_summary`)
        .then((response) => {
          this.comments_summary = response.data.comments_summary;
        })
        .catch((error) => {
          console.error(error);
        });
    },

    getCommentsCount() {
      // Obtener el valor del objeto comments_summary
      // Utiliza Object.values() para obtener un array con los valores del objeto y luego suma todos los valores usando reduce()
      return Object.values(this.comments_summary).reduce((total, value) => total + value, 0);
    },

    toggleReaction(reaction) {
      let postId = this.postId;
      let oldReaction = this.auth_reaction;

      axios
        .post(`/dashboard/${postId}/reactions`, { reaction })
        .then((response) => {
          this.reactions_summary = response.data.reactions_summary;
          this.auth_reaction = reaction;
        })
        .catch(() => {
          this.saveReaction(oldReaction, reaction);
        });

      this.saveReaction(reaction, oldReaction);
    },

    saveReaction(new_reaction, old_reaction) {
      this.resetReactionsSummary(new_reaction, old_reaction);

      if (this.auth_reaction === new_reaction) {
        this.auth_reaction = null;
        return;
      }

      this.auth_reaction = new_reaction;
    },

    resetReactionsSummary(new_reaction, old_reaction) {
      if (old_reaction) {
        this.reactions_summary[old_reaction]--;
      }

      if (new_reaction && new_reaction !== old_reaction) {
        if (!this.reactions_summary[new_reaction]) {
          this.reactions_summary[new_reaction] = 1;
          return;
        }

        this.reactions_summary[new_reaction]++;
      }
    },
  },
  computed: {
    likeImageSrc() {
      return this.auth_reaction === 'like' ? '/images/like_reacted.png' : '/images/like.png';
    },
    dislikeImageSrc() {
      return this.auth_reaction === 'dislike' ? '/images/dislike_reacted.png' : '/images/dislike.png';
    },
  },
};
</script>