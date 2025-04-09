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
                {{ sign.name }}
              <div class="video-previa">
                <iframe
                    allow="autoplay; encrypted-media"
                    :src="`${sign.display}${sign.display.includes('?') ? '&' : '?'}autoplay=1&mute=1`"
                    loading="lazy"
                >
                </iframe>
              </div>
            </AppCard>
</div>
<Pagination v-model:page="page" :lastPage="last_page" />
</template>

<script lang="ts">
import SubjectService from '~/services/SubjectService';
import useBreadcrumbStore from '~/stores/useBreadcrumbStore';
import type { SubjectType } from '~/types/Subject';

export default defineComponent({
    name: 'subjectPage',

    async setup() {
        const { id } = useRoute().params;
        const page = ref(1);
        const last_page = ref(1);
        const subject = ref<SubjectType>({
            name: '',
            signs: [],
        });

        async function getSubject() {
            const data = await SubjectService.find(Number(id), page.value);
            subject.value = data.subject;
            last_page.value = data.last_page;
        }

        try {
            getSubject();
        } catch(error) {
            console.log(error);
        }

        return {
            subject,
            page,
            last_page,
            getSubject,
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
            this.getSubject();
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