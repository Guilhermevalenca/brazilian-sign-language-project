<template>
  <form @submit.prevent="submit">
    <div class="searching-bar-container">
      <input class="searching-bar-input" type="text" v-model="search" required @input="searchAction" placeholder="Buscar ...">
      <button type="submit" class="search-button">
        <img src="~/assets/icons/search.svg" width="24px" height="24px">
      </button>
    </div>
  </form>
</template>

<script lang="ts">
import SystemSourceService from '~/services/SystemSourceService';

export default defineComponent({
  name: 'AppSearch',

  data: () => ({
    search: '',
    results: {
      courses: [],
      subjects: [],
      signs: [],
    },
  }),

  methods: {
    async searchAction() {
      if(this.search) {
        await SystemSourceService.searchAction(this.search)
            .then(res => {
              if(res) {
                this.results.courses = res.data.courses;
                this.results.subjects = res.data.subjects;
                this.results.signs = res.data.signs;
              }
            });
      } else {
        this.results.courses = [];
        this.results.subjects = [];
        this.results.signs = [];
      }
    },
    async submit() {
      const searchData = searchBarData();
      if(this.search) {
        searchData.value = this.search;
        this.$router.push(`/search`);
      }
    }

  }
});
</script>
<style scoped>
.searching-bar-container{
  display: flex;
  align-items: center;
  justify-self: center;
  margin-left: auto;
}
.searching-bar-input{
  border: none;
  border-top-left-radius: 5em;
  border-bottom-left-radius: 5em;
  padding: 0em 2em;
  width: 30em;
  height: 3.5em;
}
.search-button{
  background-color: #2266D2;
  display: flex;
  align-items: center;
  justify-content: center;
  border: none;
  border-top-right-radius: 10em;
  border-bottom-right-radius: 10em;
  cursor:pointer;
  width: 4.0em;
  height: 3.5em;
}
.searching-bar-input:focus{
  outline:#2266D2 1px solid ;
  border: #2266D2 1px solid;
  box-shadow: none;
}


</style>