<template>
  <AppCard>
    <div class="card-title">
      <img src="../../assets/logos/ou-logo-simp.svg" width="100" height="100">
      <h1>Login</h1>
    </div>
    <AppForm @submit.prevent="submit">
      <div class="input-container">
        <label for="email">Email:</label>
        <AppInput id="email" v-model="user.email" placeholder="Email" />
      </div>
      <div class="input-container">
        <label for="password">Senha:</label>
        <AppInput id="password" type="password" v-model="user.password" placeholder="Password" />
      </div>
      <div class="card-actions">
        <AppButton type="submit">Entrar</AppButton>
        <a href="/auth/register"> Não Tenho uma conta</a>
      </div>
    </AppForm>
  </AppCard>
</template>

<script lang="ts">

import User from "~/classes/User";
import AuthService from "~/services/AuthService";
import useUserStore from '~/stores/useUserStore';
import AppCard from '~/components/AppCard.vue'

export default defineComponent({
  name: "login",

  async setup() {
    definePageMeta({
      middleware: 'guest',
    })
  },

  data() {
    const user = new User({
      email: '',
      password: '',
    });
    return {
      user,
    }
  },

  methods: {
    async submit() {
      const response = await AuthService.login(this.user)

      if(response) {
        await useUserStore().data.fetch();
        await useUserStore().fetchIsAdmin();
        this.$router.push('/');
      }
    }
  }
});

</script>
<style>
.card-title{
  display: flex;
  flex-direction: column;
  align-self: center;
  justify-self: center;
}
.card-actions{
  display:flex;
  flex-direction: column;
  align-self: center;
  justify-self: center;
}
.input-container{
  display:flex;
  flex-direction: column;
}
</style>
