<template>
<Pagination v-model:page="page" :lastPage="last_page" />
<div>
    <CourseCard :course="course" />
    <br />
    <br />
    <ul>
        <fieldset>
            <legend>Materias</legend>
            <div 
                v-for="subject in course.subjects" 
                :key="subject.id"
                @click="$router.push(`/subject/${subject.id}`)"    
            >
                <ul>{{ subject.name }}</ul>
                <br />
                <br />
            </div>
        </fieldset>
    </ul>
</div>
<Pagination v-model:page="page" :lastPage="last_page" />
</template>

<script lang="ts">
import CourseService from '~/services/CourseService';
import useBreadcrumbStore from '~/stores/useBreadcrumbStore';
import type { CourseType } from '~/types/Course';
import LoadingService from "~/services/LoadingService";

export default defineComponent({
    name: 'coursePage',

    async setup() {
        const { id } = useRoute().params;
        const page = ref(1);

      const { data, status, execute, refresh } = useAsyncData(
          'fetchSubject',
          () => CourseService.find(Number(id), page.value),
          {
            default: () => ({
              course: {
                name: '',
                image: '',
                subjects: [],
              } as CourseType,
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
            course: computed((): CourseType => data.value.course),
            page,
            last_page: computed(() => data.value.last_page),
            refresh,
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
            this.refresh();
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