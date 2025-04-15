<template>
  <div class="content-container-list">
    <div class="content-title">
      <h1>Sinais da disciplina: {{ subject.name }}</h1>
    </div>
    <AppCard
        variant="list"
        v-for="sign in subject.signs" :key="sign.id"
        @click="$router.push(`/sign/${sign.id}`)"
    >
      <div class="video-previa">
        <iframe
            allow="autoplay; encrypted-media"
            :src="`${sign.display}${sign.display.includes('?') ? '&' : '?'}autoplay=1&mute=1`"
            loading="lazy"
        >
        </iframe>
      </div>
      {{ sign.name }}
    </AppCard>
  </div>
  <Pagination v-model:page="page" :lastPage="last_page" />
</template>

<script lang="ts">
import SubjectService from '~/services/SubjectService';
import useBreadcrumbStore from '~/stores/useBreadcrumbStore';
import type { SubjectType } from '~/types/Subject';
import LoadingService from "~/services/LoadingService";

export default defineComponent({
  name: 'subjectPage',

  async setup() {
    const { id } = useRoute().params;
    const page = ref(1);

    const { data, status, execute, refresh } = useAsyncData(
        'fetchSubject',
        () => SubjectService.find(Number(id), page.value),
        {
          default: () => ({
            subject: {
              name: '',
              signs: [],
            },
            last_page: 1
          })
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
      subject: computed((): SubjectType => data.value.subject),
      page,
      last_page: computed(() => data.value.last_page),
      refresh,
      id,
    }
  },

  watch: {
    async page() {
      if(this.page <= 0) {
        this.page = 1;
      }
      if(this.page > this.last_page) {
        this.page = this.last_page;
      }
      this.$swal.fire({
        icon: 'info',
        title: 'Carregando sinais',
      });
      this.$swal.showLoading();
      await this.refresh();
      this.$swal.close();
    },
    "subject.name": {
      handler($new) {
        useBreadcrumbStore().activeSubject($new ?? '', '/subject/' + this.id);
      },
      deep: true,
      immediate: true
    }
  }
})
</script>
<style lang="scss" scoped>
iframe{
  width: 120px;
  height: 80px;
  border: none;
}
</style>