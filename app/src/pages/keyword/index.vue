<template>
    <div>
        <button @click="showAddKeyword = !showAddKeyword">Adicionar palavra-chave</button>
        <form v-if="showAddKeyword" @submit.prevent="submit">
            <input type="text" v-model="newKeyword.name" placeholder="nome da nova palavra-chave" />
            <br />
            <button>Adicionar</button>
        </form>
    </div>
    <br />
    <div>
        <fieldset>
            <legend>Buscar palavra-chave</legend>
            <input type="text" v-model="keywordSearch" placeholder="palavra-chave" />
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

        try {
           keywords.value = await KeywordService.fetch();
        } catch(error) {
            console.log(error);
        }

        return {
            keywords,
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
                this.keywords = await KeywordService.fetch();
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