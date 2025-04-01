<template>
  <Pagination v-model:page="page" :lastPage="last_page"/>
  <div class="signs-container" tabindex="0" v-for="sign in signs" :key="sign.id" @click="$router.push(`/sign/${sign.id}`)">
    <div class="sign-card-item">
      <h1>{{ sign.name }}</h1>
      </div>
  </div>
  <Pagination v-model:page="page" :lastPage="last_page"/>
</template>
<script lang="ts">
import Sign, {type SignType} from "~/classes/Sign";
import useUserStore from "~/stores/useUserStore";

export default{
  name: "SignCard",
  async setup() {
    const { $axios } = useNuxtApp();
    const page = ref(1);
    const last_page = ref(1);
    const signs = ref<SignType[]>([]);

    const fetchSigns = async () => {
      const { data } = await $axios.get('/api/signs', { params: { page: page.value } });
      signs.value = data.data.map((sign: SignType) => new Sign(sign));
      last_page.value = data.last_page;
    };

    await fetchSigns();

    watch(page, async () => {
      await fetchSigns();
    });

    return {
      page,
      last_page,
      signs
    };
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
</style>