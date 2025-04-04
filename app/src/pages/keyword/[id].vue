<template>
    <pre>{{ keyword }}</pre>
    <button @click="showUpdateKeyword = !showUpdateKeyword">Atualizar palavra-chave</button>
    <form v-if="showUpdateKeyword">
        <AppInput
            type="text"
            v-model="newKeyword.name"
            name="new-keyword.name"
        />
        <button type="submit">Atualizar</button>
    </form>
</template>

<script lang="ts">
import KeywordService from '~/services/KeywordService';
import { type KeywordType } from '~/types/Keyword';

export default defineComponent({
    name: 'keywordPage',

    async setup() {
        definePageMeta({
            middleware: 'is-admin',
        });
        const { id } = useRoute().params;
        const keyword = ref<KeywordType>({
            name: ''
        });
        async function fetchKeyword() {
            const { data } = await KeywordService.find(Number(id));
            keyword.value = data;
        }
        fetchKeyword();
        return {
            keyword,
            id: Number(id),
            fetchKeyword,
        }
    },

    data() {
        const newKeyword: KeywordType = {
            name: this.keyword?.name,
        }
        return {
            showUpdateKeyword: false,
            newKeyword,
        }
    },

    methods: {
        async submit() {
            try {
                await KeywordService.update(this.newKeyword, this.id);
                await this.fetchKeyword();
                this.showUpdateKeyword = false;
                this.newKeyword.name = this.keyword.name;
            } catch(e) {
                alert('deu errado!');
            }
        }
    }
});
</script>