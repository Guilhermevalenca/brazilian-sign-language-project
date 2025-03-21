<template>
    <pre>{{ keyword }}</pre>
    <button @click="showUpdateKeyword = !showUpdateKeyword">Atualizar tarefa</button>
    <form v-if="showUpdateKeyword">
        <input  type="text" v-model="newKeyword.name"/>
        <button type="submit">Atualizar</button>
    </form>
</template>

<script lang="ts">
import Keyword from '~/classes/Keyword';

export default defineComponent({
    name: 'keywordPage',

    async setup() {
        definePageMeta({
            middleware: 'is-admin',
        });
        const { id } = useRoute().params;
        const keyword = ref(new Keyword({
            id: Number(id),
            name: ''
        }));
        await keyword.value.fetch();
        return {
            keyword,
        }
    },

    data() {
        const newKeyword = new Keyword({
            name: this.keyword?.name,
            id: this.keyword?.id
        })
        return {
            showUpdateKeyword: false,
            newKeyword,
        }
    },

    methods: {
        async submit() {
            try {
                await this.newKeyword.update();
                await this.keyword.fetch();
                this.showUpdateKeyword = false;
                this.newKeyword.name = this.keyword.name;
            } catch(e) {
                alert('deu errado!');
            }
        }
    }
});
</script>