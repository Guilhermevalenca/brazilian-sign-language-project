<template>
    <Pagination v-model:page="page" :lastPage="last_page" />
    <div v-for="subject in subjects" :key="subject.id">
        {{ subject.name }}
    </div>
    <Pagination v-model:page="page" :lastPage="last_page" />
</template>


<script lang="ts">
import SubjectService from '~/services/SubjectService';
import { type SubjectType } from '~/types/Subject';

export default defineComponent({
    name: 'subjectPage',

    async setup() {
        const subjects = ref<SubjectType[]>([]);
        const page = ref<number>(1);
        const last_page = ref<number>(1);
        
        async function getSubjects() {
            const data = await SubjectService.fetch(page.value);
            subjects.value = data.subjects;
            last_page.value = data.last_page;
        }
        
        try {
            getSubjects();
        } catch(error) {
            console.log(error);
        }

        return {
            subjects,
            page,
            last_page,
            getSubjects,
        }
    },

    watch: {
        page($new) {
            if($new <= 0) {
                this.page = 1;
            }
            if($new > this.last_page) {
                this.page = this.last_page;
            }
            this.getSubjects();
        }
    }
})
</script>