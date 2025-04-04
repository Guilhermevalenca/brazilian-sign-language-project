<template>
    <div>atualizar sinal</div>
    <form @submit.prevent="submit">
        <div>
            <p>informações do sinal</p>
            <AppInput
                v-model="sign.name"
                placeholder="Nome do sinal"
                name="sign.name"
            />
            <br />
            <AppInput
                v-model="sign.display"
                placeholder="Link do video"
                name="sign.display"
            />
            <small>Apenas links do youtube</small>
        </div>
        <div>
            <p>descrição do sinal <span class="tw-text-xs">* Campos não obrigatorios</span></p>
            <textarea
                v-model="sign.description!.text"
                placeholder="Descrição do sinal"
                name="sign.description.text"
            />
            <br />
            <AppInput
                v-model="sign.description!.display"
                placeholder="Video descrevendo o sinal"
                name="sign.description.display"
            />
            <small>Apenas links do youtube</small>
        </div>
        <div>
            <p>Exemplo de uso do sinal <span class="tw-text-xs">* Campos não obrigatorios</span></p>
            <AppInput
                v-model="sign.example!.description"
                placeholder="descrição do exemplo"
                name="sign.example.description"
            />
            <br />
            <AppInput
                v-model="sign.example!.display"
                placeholder="link do exemplo"
                name="sign.example.display"
            />
            <small>Apenas links do youtube</small>
        </div>
        <button type="submit">Atualizar sinal</button>
    </form>
</template>

<script lang="ts">
import SignService from '~/services/SignService';
import { type SignType } from '~/types/Sign';

export default defineComponent({
    name: 'updateSignPage',

    async setup() {
        definePageMeta({
            middleware: 'is-admin',
        });

        const { id } = useRoute().params;
        const sign = ref<SignType>({
            name: '',
            display: '',
            description: {
                text: '',
                display: '',
            },
            example: {
                description: '',
                display: '',
            }
        });

        async function fetchSign() {
            const { data } = await SignService.find(Number(id));
            sign.value = {
                ...sign,
                ...data,
            };
        }

        fetchSign();

        return {
            sign: ref(sign),
            id,
        }
    },

    methods: {
        async submit() {
            try {
                const sign: SignType = {...this.sign};
                if(sign.example?.description === '' || sign.example?.display === '') {
                    delete sign.example;
                }
                if(sign.description?.text === '' || sign.description?.display === '') {
                    delete sign.description;
                }
                await SignService.update(sign, Number(this.id));
                this.$router.go(-1);
            } catch (e) {
                console.log(e);
            }
        }
    }
});
</script>