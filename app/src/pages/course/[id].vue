<template>
<div class="content-container-list">
  <div class="content-title">
    <h1>Disciplinas de: {{ course.name }}</h1>
  </div>
            <AppCard
                v-for="subject in course.subjects"
                tabindex="1"
                variant="list"
                role="button"
                :key="subject.id"
                @click="$router.push(`/subject/${subject.id}`)"    
            >
                <ul>{{ subject.name }}</ul>
            </AppCard>
</div>
<Pagination v-model:page="page" :lastPage="last_page" />
</template>

<script lang="ts">
import CourseService from '~/services/CourseService';
import useBreadcrumbStore from '~/stores/useBreadcrumbStore';
import type { CourseType } from '~/types/Course';

export default defineComponent({
    name: 'coursePage',

    async setup() {
        const { id } = useRoute().params;
        const page = ref(1);
        const last_page = ref(1);
        const course = ref<CourseType>({
            name: '',
            image: '',
            subjects: [],
        });

        async function getCourse() {
            const data = await CourseService.find(Number(id), page.value);
            course.value = data.course;
            last_page.value = data.last_page;
        }
        try {
            getCourse();
        } catch(error) {
            console.log(error);
        }

        return {
            course,
            page,
            last_page,
            getCourse,
            id
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
            this.getCourse();
        },
        "course.name": {
            handler($new) {
                useBreadcrumbStore().activeCourse($new ?? '', '/course/' + this.id);
            },
            deep: true,
            immediate: true,
        }
    },
})
</script>