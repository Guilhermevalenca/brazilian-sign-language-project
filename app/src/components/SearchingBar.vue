<template>
  <div class="searching-bar-container">
    <form @submit.prevent="submit" v-bind="$attrs">
      <div class="searching-bar">
        <input
            class="searching-bar-input" type="text"
            v-model="search" required

            placeholder="Buscar ..."
            name="search-bar"
        >
        <button type="submit" class="search-button">
          <img src="~/assets/icons/search.svg" width="24px" height="24px">
        </button>
      </div>
    </form>
  </div>
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
        navigateTo('/search');
        this.search = ''
      }
    }

  }
});
</script>
<style lang="scss" scoped >
.searching-bar-container{
  display: flex;
  flex: auto;
}
.searching-bar{
  display: flex;
  flex-direction: row;
  flex:auto;
}
.searching-bar-input{
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
.search-button{
  background-color: $secondary-color;
  border: none;
  border-top-right-radius: 10rem;
  border-bottom-right-radius: 10rem;
  cursor:pointer;
  width: 4rem;
  height: 3rem;
}
.searching-bar-input:focus{
  outline:$secondary-color 1px solid ;
  border: $secondary-color 1px solid;
  box-shadow: none;
}


</style>