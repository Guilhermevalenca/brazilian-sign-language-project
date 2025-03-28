<template>
    <button @click="page--" :disabled="page === 1">Anterior</button>
    <button @click="page++" :disabled="page === last_page">Proxima</button>
    <pre>{{ subjects }}</pre>
</template>


<script lang="ts">
import SubjectService from '~/services/SubjectService';
import Subject from '~/classes/Subject';

export default defineComponent({
    name: 'subjectPage',

    async setup() {
        const subjects = ref<Subject[]>([]);
        const page = ref<number>(1);
        const last_page = ref<number>(1);
        
        async function getSubjects() {
            const data = await SubjectService.fetch(page.value);
            subjects.value = data.subjects;
            last_page.value = data.last_page;
        }
        
        await getSubjects();

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