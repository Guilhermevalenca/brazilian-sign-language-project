<template>
  <div class="pagination-container" v-if="lastPage > 1">
    <!-- Botão Anterior -->
    <button class="pagination-button" @click="changePage(page - 1)" :disabled="page === 1">
      <img src="~/assets/icons/arrow-left.svg" alt="Anterior" />
    </button>

    <!-- Números das Páginas -->
    <button
      v-for="p in lastPage" :key="p"
      class="pagination-number"
      :class="{ active: p === page }"
      @click="changePage(p)"
    >
      {{ p }}
    </button>

    <!-- Botão Próximo -->
    <button class="pagination-button" @click="changePage(page + 1)" :disabled="page === lastPage">
      <img src="~/assets/icons/arrow-right.svg" alt="Próximo" />
    </button>
  </div>
</template>

<script setup lang="ts">
const props = defineProps({
  page: { type: Number, required: true }, // Página atual
  lastPage: { type: Number, required: true }, // Última página dinâmica
});

const emit = defineEmits(['update:page']);

function changePage(newPage: number) {
  if (newPage >= 1 && newPage <= props.lastPage) {
    emit('update:page', newPage);
  }
}
</script>

<style lang="scss" scoped>
.pagination-container {
  display: flex;
  flex-flow: row nowrap;
  box-sizing: border-box;
  align-items: center;
  align-content: center;
  justify-content: center;
  background-color: transparent;
  color: #ffffff;
  border-radius: 10rem;
  gap: 1em;
  margin: 1.5em;
}
.container-pagination-item {
  display: flex;
  flex: auto;
  padding: 0.5rem;
}
.pagination-number {
  display: flex;
  justify-content: center;
  border: none;
  border-radius: 100%;
  background-color: $primary-color;
  padding: 0.5em;
  width: 2.5em;
  height: 2.5em;
}
.pagination-button {
  display: flex;
  align-items: center;
  border: none;
  border-radius: 100%;
  padding: 0.2em;
  background-color: $primary-color;
  border: none;
  img {
    width: 1.5rem;
    height: 1.5rem;
  }
}
.active{
  background-color: $secondary-color;
  transform: scale(1.2,1.2);
}
button:hover{
  justify-self: center;
  transform: scale(1.2,1.2);
  background-color: $primary-color-hovered;
}
</style>
