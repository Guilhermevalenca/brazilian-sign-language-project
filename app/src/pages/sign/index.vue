<template>
  <div class="content-container-list">
    <Pagination v-model:page="page" :lastPage="last_page"/>
  <div 
    class="signs-container" tabindex="0" 
    v-for="sign in signs" :key="sign.id" 
    @click="$router.push(`/sign/${sign.id}`)"
    role="button"
  >
    <div class="sign-card-item">
      <h1>{{ sign.name }}</h1>
      </div>
  </div>
  <Pagination v-model:page="page" :lastPage="last_page"/>
  </div>
</template>

<script lang="ts">
import SignService from "~/services/SignService";
import {type SignType} from "~/types/Sign";

export default defineComponent({
    name: 'signPage',

    async setup() {
    const page = ref(1);
    const last_page = ref(1);
    const signs = ref<SignType[]>([]);

    async function fetchSigns() {
      const data = await SignService.fetch(page.value);
      signs.value = data.signs;
      last_page.value = data.last_page;
    };

    fetchSigns();

    return {
      page,
      last_page,
      signs,
      fetchSigns,
    };
  },

  watch: {
    async page() {
      await this.fetchSigns();
    }
  }
});
</script>

<style scoped lang="scss">
.signs-container{
  display: flex;
  flex-flow: row nowrap;
  justify-content: stretch;
  align-items: center;
  background-color: $tertiary-color;
  border: none 0.1rem;
  width: 35vw;
  border-radius: 1rem;
  padding: 0.8rem;
}
.sign-card-item{
  display: flex;
  flex: auto;
}
</style>