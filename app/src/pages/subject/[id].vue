<template>
<Pagination v-model:page="page" :lastPage="last_page" />
<div>
    <ul>
        <strong>{{ subject.name }}</strong>
    </ul>
    <br />
    <br />
    <ul>
        <fieldset>
            <legend>Sinais</legend>
            <div 
                v-for="sign in subject.signs" :key="sign.id"
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