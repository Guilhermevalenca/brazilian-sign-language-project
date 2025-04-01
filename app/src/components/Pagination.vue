<template>
  <div class="pagination-container">
    <!-- Botão Anterior -->
    <button
        class="pagination-button"
        @click="changePage(page - 1)"
        :disabled="page === 1"
    >
      <img src="~/assets/icons/arrow-left.svg" alt="Anterior"/>
    </button>

    <!-- Números das Páginas -->
    <button
        v-for="p in pages"
        :key="p"
        class="pagination-number"
        :class="{ active: p === page }"
        @click="changePage(p)"
    >
      {{ p }}
    </button>

    <!-- Botão Próximo -->
    <button
        class="pagination-button"
        @click="changePage(page + 1)"
        :disabled="page === lastPage"
    >
      <img src="~/assets/icons/arrow-right.svg" alt="Próximo"/>
    </button>
  </div>
</template>

<script lang="ts">
import { defineComponent, computed } from 'vue';

export default defineComponent({
  props: {
    page: { type: Number, required: true }, // Página atual
    lastPage: { type: Number, required: true }, // Última página dinâmica
  },

  emits: ['update:page'],

  computed: {
    Page() {
      return this.page;
    },

    pages() {
      return Array.from({ length: this.lastPage }, (_, i) => i + 1);
    }
  },

  methods: {
    changePage(newPage: number) {
      if (newPage >= 1 && newPage <= this.lastPage) {
        this.$emit('update:page', newPage);
      }
    }
  }
});
</script>

<style lang="scss" scoped>
.pagination-container{
  display: flex;
  flex-flow: row nowrap;
  box-sizing: border-box;
  align-items: center;
  align-content: center;
  justify-content: center;
  background-color: transparent;
  color: #FFFFFF;
  border-radius: 10rem;
  gap: 1em;
}
.container-pagination-item{
  display: flex;
  flex: auto;
  padding: 0.5rem;
}
.pagination-number{
  display: flex;
  justify-content: center;
  border: none;
  background-color: $primary-color;
  padding: 0.5em;
  width: 2.5em;
  height: 2.5em;
}
.pagination-button{
  display: flex;
  align-items: center;
  background-color: transparent;
  border: none;
  img{
    width: 1.5rem;
    height: 1.5rem;
  }
}
</style>
