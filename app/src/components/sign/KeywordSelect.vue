<template>
    <input type="text" v-model="keywordSearch" />
    <br />
    <select
        multiple
        required
        v-model="selected"
    >
        <option 
            v-for="keyword in keywordsFiltered" :key="keyword.id" 
            :value="keyword"
        >
            {{ keyword.name }}
        </option>
    </select>
    <br />
    <button type="button" @click="isAddKeyword = !isAddKeyword">Adicionar palavra-chave</button>
    <form v-if="isAddKeyword" @submit.prevent="submit">
        <div>
            <label>Nome da palavra-chave</label>
            <input  v-model="newKeyword.name" />
        </div>
        <button type="submit">Adicionar</button>
    </form>
</template>

<script lang="ts">
import type { PropType } from 'vue';
import Keyword, { type KeywordType } from '~/classes/Keyword';

export default defineComponent({
    name: 'KeywordSelect',

    async setup() {
        const { $axios } = useNuxtApp();
        const token = useCookie('token').value;
        if(token) {
            $axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
        }
        const keywords = ref<Keyword[]>([]);

        async function fetchKeywords() {
            const { data } = await $axios.get('/api/keywords/create');
            keywords.value = data.map((keyword: KeywordType) => new Keyword(keyword));
        }
        fetchKeywords();

        return {
            keywords,
            fetchKeywords,
        }
    },

    data: () => ({
        keywordSearch: '',
        newKeyword: new Keyword({
            name: '',
        }),
        isAddKeyword: false,
    }),

    props: {
        modelValue: {
            type: Array as PropType<Keyword[]>,
            required: true
        }
    },

    emits: ['update:modelValue'],

    computed: {
        selected: {
            get(): Keyword[] {
                return this.modelValue;
            },
            set(value: Keyword[]) {
                this.$emit('update:modelValue', value);
            }
        },
        keywordsFiltered(): Keyword[] {
            return this.keywords.filter((keyword) => {
                if(keyword.name) {
                    return keyword.name.toLowerCase().includes(this.keywordSearch.toLowerCase());
                } else {
                    return false;
                }
            })
        }
    },

    methods: {
        async submit() {
            try {
                await this.$axios.post('/api/keywords', this.newKeyword);
                await this.fetchKeywords();
                this.isAddKeyword = false;
                this.newKeyword.name = '';
            } catch(e) {
                console.log(e);
                alert('deu errado!');
            }
        }
    }
});
</script>