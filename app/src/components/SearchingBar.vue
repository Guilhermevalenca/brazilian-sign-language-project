<template>
  <div class="searching-bar-container">
    <form v-bind="$attrs" @submit.prevent="submit">
      <div class="searching-bar">
        <input
          v-model="searchData"
          class="searching-bar-input"
          type="text"
          required
          placeholder="Buscar ..."
          name="search-bar"
        />
        <button type="submit" class="search-button">
          <img src="~/assets/icons/search.svg" width="24px" height="24px" alt="Buscar" />
        </button>
      </div>
    </form>
  </div>
</template>

<script setup lang="ts">
// import SystemSourceService from '~/services/SystemSourceService';

const searchData = searchBarData();
// const results = ref({
//   courses: [],
//   subjects: [],
//   signs: [],
// });

async function submit() {
  if (searchData.value) {
    navigateTo('/search');
  }
}
// async function searchAction() {
//   if (searchData.value) {
//     await SystemSourceService.searchAction(searchData.value).then((res) => {
//       if (res) {
//         results.value.courses = res.data.courses;
//         results.value.subjects = res.data.subjects;
//         results.value.signs = res.data.signs;
//       }
//     });
//   } else {
//     results.value.courses = [];
//     results.value.subjects = [];
//     results.value.signs = [];
//   }
// }
</script>

<style lang="scss" scoped>
.searching-bar-container {
  display: flex;
  flex: auto;
}
.searching-bar {
  display: flex;
  flex-direction: row;
  flex: auto;
}
.searching-bar-input {
  font-size: 1rem;
  border: none;
  border-top-left-radius: 5rem;
  border-bottom-left-radius: 5rem;
  padding: 0rem 2rem;
  min-width: 25vw;
  max-width: 30vw;
  width: auto;
  height: 3rem;
}
.search-button {
  background-color: $secondary-color;
  border: none;
  border-top-right-radius: 10rem;
  border-bottom-right-radius: 10rem;
  cursor: pointer;
  width: 4rem;
  height: 3rem;
}
.searching-bar-input:focus {
  outline: $secondary-color 1px solid;
  border: $secondary-color 1px solid;
  box-shadow: none;
}
</style>
