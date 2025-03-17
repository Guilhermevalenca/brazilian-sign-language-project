<template>
    <form @submit.prevent="submit">
        <div>
            <p>informações do sinal</p>
            <input v-model="sign.name" placeholder="Nome do sinal">
            <br />
            <input v-model="sign.display" placeholder="Link do video">
            <small>Apenas links do youtube</small>
        </div>
        <div>
            <p>descrição do sinal <span class="tw-text-xs">* Campos não obrigatorios</span></p>
            <textarea v-model="sign.getDescription()!.text" placeholder="Descrição do sinal"></textarea>
            <br />
            <input v-model="sign.getDescription()!.display" placeholder="Video descrevendo o sinal">
            <small>Apenas links do youtube</small>
        </div>
        <div>
            <p>Exemplo de uso do sinal <span class="tw-text-xs">* Campos não obrigatorios</span></p>
            <input v-model="sign.getExample()!.description" placeholder="descrição do exemplo" />
            <br />
            <input v-model="sign.getExample()!.display" placeholder="link do exemplo" />
            <small>Apenas links do youtube</small>
        </div>
        <button type="submit">criar sinal</button>
    </form>
</template>

<script lang="ts">
import Sign from '~/classes/Sign';

export default defineComponent({
    name: 'signCreatePage',

    async setup() {
        definePageMeta({
            middleware: 'is-admin',
        })
    },

    data() {
        const sign = new Sign({
            name: '',
            display: ''
        });

        sign.setExample();
        sign.setDescription();

        return {
            sign,
        }
    },

    methods: {
        async submit() {
            try {
                if(!this.sign.getExample()?.description || !this.sign.getExample()?.display) {
                    this.sign.resetExample();
                }
                if(!this.sign.getDescription()?.text || !this.sign.getDescription()?.display) {
                    this.sign.resetDescription();
                }
                await this.sign.register(this.$axios);
                this.$router.push('/sign');
            } catch (e) {
                console.log(e);
            }
        }
    }
});
</script>