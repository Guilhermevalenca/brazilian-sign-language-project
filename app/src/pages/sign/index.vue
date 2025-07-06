<template>
  <div class="content-container-list">
    <Pagination v-model:page="page" :lastPage="last_page"/>
    <div
        class="signs-container" tabindex="0"
        v-for="sign in signs" :key="sign.id"
        @click="navigateTo(`/sign/${sign.id}`)"
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
import LoadingService from "~/services/LoadingService";

export default defineComponent({
  name: 'signPage',

  async setup() {
    const page = ref(1);

    const { data, status, execute, refresh } = useAsyncData(
        'fetchSigns',
        () => SignService.fetch(page.value),
        {
          default: () => ({
            signs: [],
            last_page: 1
          }),
          lazy: true,
          immediate: false
        }
    );

    onBeforeMount(() => {
      LoadingService.show();
      setTimeout(() => {
        LoadingService.loaded(status.value, refresh);
      }, 300);
    });

    watch(status, ($new) => {
      LoadingService.loaded($new, refresh);
    });

    execute();

    return {
      page,
      last_page: computed(() => data.value.last_page),
      signs: computed(() => data.value.signs),
      refresh,
    };
  },

  watch: {
    async page($new) {
      if($new <= 0) {
        this.page = 1;
      }
      if($new > this.last_page) {
        this.page = this.last_page;
      }
      this.$swal.fire({
        icon: 'info',
        title: 'Carregando sinais',
      });
      this.$swal.showLoading();
      await this.refresh();
      this.$swal.close();
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