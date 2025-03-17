<template>
    <form @submit.prevent="submit">
        <input v-model="search" required @input="searhAction" />
        <button type="submit">pesquisar</button>
    </form>
    <fieldset>
        <p>Resultados:</p>
        <div class="tw-flex tw-gap-2">
            <div>
                <p>Cursos</p>
                <pre>{{ results.courses }}</pre>
            </div>
            <div>
                <p>Materias</p>
                <pre>{{ results.subjects }}</pre>
            </div>
            <div>
                <p>Sinais</p>
                <pre>{{ results.signs }}</pre>
            </div>
        </div>
    </fieldset>
</template>


<script lang="ts">
import SystemSourceService from '~/services/SystemSourceService';

export default defineComponent({
    name: 'AppSearch',

    data: () => ({
        search: '',
        results: {
            courses: [],
            subjects: [],
            signs: [],
        }
    }),

    methods: {
        async searhAction() {
            if(this.search) {
                await SystemSourceService.searhAction(this.search)
                .then(res => {
                    if(res) {
                        this.results.courses = res.data.courses;
                        this.results.subjects = res.data.subjects;
                        this.results.signs = res.data.signs;
                    }
                });
            } else {
                this.results.courses = [];
                this.results.subjects = [];
                this.results.signs = [];
            }
        },
        async submit() {
            const searchData = searchBarData();
            if(this.search) {
                searchData.value = this.search;
                this.$router.push(`/search`);
            }
        }
        
    }
});
</script>