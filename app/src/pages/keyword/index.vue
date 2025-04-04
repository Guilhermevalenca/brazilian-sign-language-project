<template>
    <div>
        <button @click="showAddKeyword = !showAddKeyword">Adicionar palavra-chave</button>
        <form v-if="showAddKeyword" @submit.prevent="submit">
            <AppInput
                type="text"
                v-model="newKeyword.name"
                placeholder="nome da nova palavra-chave"
                name="new-keyword.name"
            />
            <br />
            <button>Adicionar</button>
        </form>
    </div>
    <br />
    <div>
        <fieldset>
            <legend>Buscar palavra-chave</legend>
            <AppInput
                type="text"
                v-model="keywordSearch"
                placeholder="palavra-chave"
                name="keyword-search"
            />
        </fieldset>
    </div>
    <br />
    <p>Palavras-chave</p>
    <div v-for="keyword in keywordsFiltered" :key="keyword.id">
        <fieldset>
            <pre>{{ keyword }}</pre>
            <NuxtLink :to="`/keyword/${keyword.id}`">Atualizar palavra-chave</NuxtLink>
        </fieldset>
    </div>
    <AppButton @click="page++" :disabled="page === last_page">Carregar mais palavras-chave</AppButton>
</template>

<script lang="ts">
import type { KeywordType } from '~/types/Keyword';
import KeywordService from '~/services/KeywordService';

export default defineComponent({
    name: 'keywordPage',

    async setup() {
        definePageMeta({
            middleware: 'is-admin',
        });

        const keywords = ref<KeywordType[]>([]);
        const page = ref(1);
        const last_page = ref(1);
        
        async function getKeywords() {
            const data = await KeywordService.fetch(page.value);
            keywords.value.push(...data.keywords);
            last_page.value = data.last_page;
        }

        try {
           getKeywords();
        } catch(error) {
            console.log(error);
        }

        return {
            keywords,
            page,
            last_page,
            getKeywords,
        }
    },

    data: () => ({
        keywordSearch: '',
        newKeyword: {
            name: '',
        } as KeywordType,
        showAddKeyword: false
    }),

    methods: {
        async submit() {
            try {
                await KeywordService.create(this.newKeyword);
                this.page = 1;
                this.keywords = [];
                await this.getKeywords();
                this.showAddKeyword = false;
                this.newKeyword.name = '';
            } catch(e) {
                alert('deu errado!');
            }
        }
    },

    computed: {
        keywordsFiltered(): KeywordType[] {
            return this.keywords.filter((keyword: KeywordType) => {
                if(keyword.name) {
                    return keyword.name.toLowerCase().includes(this.keywordSearch.toLowerCase());
                } else {
                    return false;
                }
            })
        }
    }
});
</script>