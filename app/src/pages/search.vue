<template>
    <form>
        <p>Filtros</p>
        <div class="tw-flex tw-gap-2">
            <div>
                <input type="checkbox" v-model="filterOptions.courses" />
                <label>Cursos</label>
            </div>
            <div>
                <input type="checkbox" v-model="filterOptions.subjects" />
                <label>Materias</label>
            </div>
            <div>
                <input type="checkbox" v-model="filterOptions.signs" />
                <label>Sinais</label>
            </div>
        </div>
    </form>
    <pre>{{ {page, last_page} }}</pre>
    <div>
        <button @click="previousPage" :disabled="page === 1">Anterior</button>
        <button @click="nextPage" :disabled="page === last_page">Proxima</button>
    </div>
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
import SystemSourceService, { type FilterOptionsType } from '~/services/SystemSourceService';

export default defineComponent({
    name: 'searchPage',

    async setup() {
        const searchData = searchBarData();
        const results = ref({
            courses: [],
            subjects: [],
            signs: []
        });
        const filterOptions = ref<FilterOptionsType>({
            courses: false,
            subjects: false,
            signs: false
        });
        const last_page = ref(1);
        const page = ref(1);

        async function searchAction() {
            const search = searchData?.value;
            if(search) {
                await SystemSourceService.searchActionWithFilter(
                    search,
                    filterOptions.value, 
                    page.value
                )
                    .then((res) => {
                        if(res) {
                            last_page.value = res.data.last_page;
                            results.value.courses = [];
                            results.value.subjects = [];
                            results.value.signs = [];

                            for(const value of res.data.data) {
                                if(value.courses) {
                                    results.value.courses.push(value.courses);
                                }
                                if(value.subjects) {
                                    results.value.subjects.push(value.subjects);
                                }
                                if(value.signs) {
                                    results.value.signs.push(value.signs);
                                }
                            }
                        }
                    });
                }
        }

        await searchAction();

        watch(searchData, async () => {
            await searchAction();
        });

        return {
            results,
            filterOptions,
            searchAction,
            last_page,
            page,
        }
    },

    watch: {
        filterOptions: {
            handler() {
                this.searchAction();
            },
            deep: true,
        },
        search() {
            this.page = 1;
        }
    },

    methods: {
        async nextPage() {
            if(this.page < this.last_page) {
                this.page++;
            }
            await this.searchAction();
        },
        async previousPage() {
            if(this.page > 1) {
                this.page--;
            }
            await this.searchAction();
        }
    },
})
</script>