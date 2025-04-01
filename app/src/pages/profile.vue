<template>
    <fieldset>
        <p>Perfil:</p>
        <form @submit.prevent="submitProfile">
            <input v-model="user.name" placeholder="Nome" />
            <br />
            <input v-model="user.email" placeholder="Email" />
            <br />
            <button type="submit">Salvar</button>
        </form>
    </fieldset>
    <fieldset>
        <p>Senha:</p>
        <form @submit.prevent="submitPassword">
            <input v-model="user.password" placeholder="Senha Atual" />
            <br />
            <input v-model="user.new_password" placeholder="Nova Senha" />
            <br />
            <input v-model="user.new_password_confirmation" placeholder="Confirmação Senha" />
            <br />
            <button type="submit">Salvar</button>
        </form>
    </fieldset>
    <fieldset>
        <p>Excluir Conta:</p>
        <form @submit.prevent="submitDelete">
            <input v-model="passwordDelete" placeholder="Senha" />
            <button type="submit">Excluir</button>
        </form>
    </fieldset>
</template>

<script lang="ts">
import ProfileService from '~/services/ProfileService';
import useUserStore from '~/stores/useUserStore';

export default defineComponent({
    name: 'profilePage',

    async setup() {
        definePageMeta({
            middleware: 'auth',
        });
    },

    data() {
        return {
            user: {
                name: '',
                email: '',
                password: '',
                new_password: '',
                new_password_confirmation: '',
            },
            passwordDelete: '',
            userStore: null as null | ReturnType<typeof useUserStore>,
        }
    },

    mounted() {
        this.userStore = useUserStore();
    },

    watch: {
        userStore: {
            handler() {
                this.user.email = String(this.userStore?.data?.email ?? '');
                this.user.name = String(this.userStore?.data?.name ?? '');
            },
            deep: true,
            immediate: true
        }
    },

    methods: {
        async submitProfile() {
            await ProfileService.updateProfile(this.user)
                .then(res => {
                    if(res && this.userStore) {
                        this.userStore.data!.name = this.user.name;
                        this.userStore.data!.email = this.user.email;
                        alert('salvo!');
                        this.user.name = '';
                        this.user.email = '';
                    }
                });
        },
        async submitPassword() {
            await ProfileService.updatePassword(this.user)
                .then((res) => {
                    if(res) {
                        alert('salvo!');
                        this.user.password = '';
                        this.user.new_password = '';
                        this.user.new_password_confirmation = '';
                    }
                })
        },
        async submitDelete() {
            await ProfileService.deleteAccount(this.passwordDelete)
                .then((res) => {
                    if(res) {
                        localStorage.removeItem('token');
                        delete this.$axios.defaults.headers.common['Authorization'];
                        
                        const tokenCookie = useCookie('token');
                        tokenCookie.value = null;
                        
                        this.userStore!.resetDatas();
                        this.$router.push('/auth/login');
                    }
            })
        }
    }
})
</script>