<template>
  <div>
    <div>
      <button
        @click="toggleReaction('like')"
        class="btn btn-link"
        :class="{ active: auth_reaction === 'like' }"
      >
        <img :src="image('like')" />
        <span style="color: white;">{{ reactions_summary.like || 0 }}</span>
      </button>

      <button
        @click="toggleReaction('dislike')"
        class="btn btn-link"
        :class="{ active: auth_reaction === 'dislike' }"
      >
        <img :src="image('dislike')" />
        <span style="color: white;">{{ reactions_summary.dislike || 0 }}</span>
      </button>
    </div>
  </div>
</template>

<script>
export default {
  props: ["postId"],

  data() {
    return {
      reactions_summary: {},
      auth_reaction: null,
    };
  },

  mounted() {
    this.fetchReactionsSummary();
  },

  methods: {
    image(type) {
      return `/reactions_${type}.png`; // Reemplaza la ruta de los emojis según sea necesario
    },

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
};
</script>