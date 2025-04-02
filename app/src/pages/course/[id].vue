<template>
<Pagination v-model:page="page" :lastPage="last_page" />
<div>
    <ul>{{ course.name }}</ul>
    <ul>{{ course.image }}</ul>
    <ul>
        <div 
            v-for="subject in course.subjects" 
            :key="subject.id"
            @click="$router.push(`/subject/${subject.id}`)"    
        >
            <ul>{{ subject.name }}</ul>
            <br />
            <br />
        </div>
    </ul>
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
                useBreadcrumbStore().activeCourse($new ?? '');
            },
            deep: true,
            immediate: true,
        }
    },
})
</script>