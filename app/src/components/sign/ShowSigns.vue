<template>
  <div class="pagination-container">
    <div class="container-pagination-item">
      <button class="pagination-button" @click="previousPage" :disabled="page === 1">
        <img src="~/assets/icons/arrow-left.svg">
      </button>
    </div>
    <div class="container-pagination-item">
      <span>Página {{ page }}</span>
    </div>
    <div class="container-pagination-item">
      <button class="pagination-button" @click="nextPage" :disabled="page === last_page">
        <img src="~/assets/icons/arrow-right.svg">
      </button>
    </div>
  </div>
  <div class="signs-container" tabindex="0" v-for="sign in signs" :key="sign.id" @click="$router.push(`/sign/${sign.id}`)">
    <div class="sign-card-item">
      <h1>{{ sign.name }}</h1>
      </div>
  </div>
  <div class="pagination-container">
    <div class="container-pagination-item">
      <button class="pagination-button" @click="previousPage" :disabled="page === 1">
        <img src="~/assets/icons/arrow-left.svg">
      </button>
    </div>
    <div class="container-pagination-item">
      <span>Página {{ page }}</span>
    </div>
    <div class="container-pagination-item">
      <button class="pagination-button" @click="nextPage" :disabled="page === last_page">
        <img src="~/assets/icons/arrow-right.svg">
      </button>
    </div>
  </div>
</template>
<script lang="ts">
import Sign, {type SignType} from "~/types/Sign";
import useUserStore from "~/stores/useUserStore";

export default{
  name: "SignCard",
  async setup() {
    const { $axios } = useNuxtApp();
    const { data } = await $axios.get('/api/signs');

    return {
      last_page: ref(data.last_page),
      page: ref(1),
      signs: ref(data.data.map((sign: SignType) => new Sign(sign))),
    }
  },

  data() {
    return {
      userStore: null as null | ReturnType<typeof useUserStore>,
    }
  },
  methods: {
    async nextPage() {
      const { data } = await this.$axios.get('/api/signs', {
        params: {
          page: ++this.page
        }
      });
      this.last_page = data.last_page;
      this.signs = data.data.map((sign: SignType) => new Sign(sign));
    },

    async previousPage() {
      const { data } = await this.$axios.get('/api/signs', {
        params: {
          page: --this.page
        }
      });
      this.last_page = data.last_page;
      this.signs = data.data.map((sign: SignType) => new Sign(sign));
    }
  },

  mounted() {
    this.userStore = useUserStore();
  },
}
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
.pagination-container{
  display: flex;
  flex-flow: row nowrap;
  box-sizing: border-box;
  align-items: center;
  align-content: center;
  justify-content: center;
  background-color: $primary-color;
  color: #FFFFFF;
  border-radius: 10rem;
}
.container-pagination-item{
  display: flex;
  flex: auto;
  padding: 0.5rem;
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