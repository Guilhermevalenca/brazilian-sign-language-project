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
import Keyword from '~/classes/Keyword';
import KeywordService from '~/services/KeywordService';

export default defineComponent({
    name: 'keywordPage',

    async setup() {
        definePageMeta({
            middleware: 'is-admin',
        });

        const keywords = ref<Keyword[]>(await KeywordService.fetch());
        return {
            keywords,
        }
    },

    data: () => ({
        keywordSearch: '',
        newKeyword: new Keyword({
            name: '',
        }),
        showAddKeyword: false
    }),

    methods: {
        async submit() {
            try {
                await this.newKeyword.register();
                this.keywords = await KeywordService.fetch();
                this.showAddKeyword = false;
                this.newKeyword.name = '';
            } catch(e) {
                alert('deu errado!');
            }
        }
    },

    computed: {
        keywordsFiltered(): Keyword[] {
            return this.keywords.filter((keyword: Keyword) => {
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