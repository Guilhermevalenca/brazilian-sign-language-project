<template>
  <AppCard>
    <AppLogo/>
    <h1>Cadastro</h1>
    <AppForm @submit.prevent="submit">
      <label>Nome:
        <AppInput v-model="user.name" placeholder="Digite seu nome" />
      </label>
      <label>Email:
        <AppInput v-model="user.email" placeholder="Digite seu email" />
      </label>
      <label>Senha:
        <AppInput type="password" v-model="user.password" placeholder="Escolha uma senha" />
      </label>
      <label>Confirme sua senha:
        <AppInput type="password" v-model="user.password_confirmation" placeholder="Confirme sua senha" />
      </label>
      <FormActions>
        <a href="/auth/login" margin-left="auto" >Já tenho uma conta</a>
        <AppButton type="submit">Cadastrar-se</AppButton>
      </FormActions>
    </AppForm>
  </AppCard>
</template>

<script lang="ts">
import User from "~/classes/User";
import useUserStore from '~/stores/useUserStore';
import {type AxiosError, type AxiosResponse} from "axios";
import FormActions from "~/components/FormActions.vue";

export default defineComponent({
  name: "register",
  components: {FormActions},

  async setup() {
    definePageMeta({
      middleware: 'guest',
    })
  },

  data() {
    const user = new User({
      name: '',
      email: '',
      password: '',
      password_confirmation: '',
    });
    return {
      user,
    }
  },

  methods: {
    async submit() {
      try {
        const res = await this.user.register();
        if(typeof res === 'object' && 'data' in res) {
          const token = res.data.token;
          this.$axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
          localStorage.setItem('token', token);

          const tokenCookie = useCookie('token');
          tokenCookie.value = token;

          await useUserStore().data.fetch();
          await useUserStore().fetchIsAdmin();
          this.$router.push('/auth/check-email-code');
        }
      } catch (e: AxiosResponse | AxiosError | any) {
        console.log(e);
      }
    }
  },
});

</script>