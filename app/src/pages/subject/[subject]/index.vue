<template>
  <AppButton @click="deleteSubject">deletar disciplina</AppButton>
  <AppButton @click="() => navigateTo('/subject/' + id + '/update')">editar disciplina</AppButton>
  <div class="content-title">
    <h1>Sinais da disciplina {{ subject?.name }}</h1>
  </div>
  <div v-if="subject?.signs && subject?.signs.length > 0" class="content-container-list">
    <AppCard
        class="sign-view"
        variant="list"
        v-for="sign in subject?.signs ?? []" :key="sign.id"
        @click="navigateTo(`/sign/${sign.id}`)"
    >
      <div class="video-previa">
        <LazyClientOnly>
          <iframe
              allow="autoplay; encrypted-media"
              :src="`${sign.display}${sign.display.includes('?') ? '&' : '?'}autoplay=0&mute=1`"
              loading="lazy"
          >
          </iframe>
        </LazyClientOnly>
      </div>
      <p>
        {{ sign.name }}
      </p>
    </AppCard>
  </div>
  <EmptySection v-else>
    <p> Nenhum sinal encontrado em {{ subject.name }}.</p>
  </EmptySection>
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
    const { subject: id } = useRoute().params;
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
          }),
          immediate: false,
          lazy: true,
        }
    );

    onBeforeMount(() => {
      LoadingService.show();
      setTimeout(() => {
        console.log(status.value);
        LoadingService.loaded(status.value, refresh);
      }, 300);
    });

    watch(status, ($new) => {
      console.log($new);
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
  },

  methods: {
    async deleteSubject() {
      const { $swal } = useNuxtApp();
      try {
        $swal.fire({
          icon: 'info',
          title: 'Deletando disciplina...',
        });
        $swal.showLoading();
        await SubjectService.delete(Number(this.id));
        await $swal.fire({
          icon: 'success',
          title: 'Disciplina deletada com sucesso',
          timer: 5000,
          showConfirmButton: true,
          confirmButtonText: 'OK',
        });
        navigateTo('/');
      } catch(e) {
        await $swal.fire({
          icon: 'error',
          title: 'Algo deu errado',
          text: 'Ocorreu um erro, gostaria de tentar novamente ?',
          timer: 3000,
          showConfirmButton: true,
          confirmButtonText: 'Tentar novamente',
        });
      }
    }
  }
})
</script>
<style lang="scss" scoped>
iframe{
  width: 120px;
  height: 80px;
  border: none;
  border-radius: 1em;
}
.sign-view{
  display: flex;
  flex-flow: row;
  padding: 0.5em;
}
</style>