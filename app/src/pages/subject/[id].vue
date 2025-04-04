<template>
  <Pagination v-model:page="page" :lastPage="last_page" />
  <div>
    <ul>
      <strong>{{ subject?.name }}</strong>
    </ul>
    <br />
    <br />
    <ul>
      <fieldset>
        <legend>Sinais</legend>
        <div
            v-for="sign in subject?.signs" :key="sign.id"
            @click="$router.push(`/sign/${sign.id}`)"
        >
          <ul>{{ sign.name }}</ul>
          <ul>{{ sign.display }}</ul>
          <br />
          <br />
        </div>
      </fieldset>
    </ul>
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

    watch(status, ($new) => {
      LoadingService.show($new, refresh);
    }, {
      immediate: true,
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
    page() {
      if(this.page <= 0) {
        this.page = 1;
      }
      if(this.page > this.last_page) {
        this.page = this.last_page;
      }
      this.refresh();
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