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
import Keyword from '~/classes/Keyword';
import KeywordService from '~/services/KeywordService';

export default defineComponent({
    name: 'KeywordSelect',

    async setup() {
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
                await this.newKeyword.register();
                this.keywords = await KeywordService.fetch();
                this.isAddKeyword = false;
                this.newKeyword.name = '';
            } catch(e) {
                alert('deu errado!');
            }
        }
    }
});
</script>