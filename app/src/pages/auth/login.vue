<template>
<form @submit.prevent="submit">
  <input v-model="user.email" placeholder="Email" />
  <br />
  <input v-model="user.password" placeholder="Password" />
  <br />
  <button type="submit">login</button>
</form>
</template>

<script lang="ts">

import User from "~/classes/User";
import AuthService from "~/services/AuthService";
import useUserStore from '~/stores/useUserStore';

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
      const response = await AuthService.login(this.$axios, this.user)

      if(response) {
        await useUserStore().data.fetch(this.$axios);
        await useUserStore().fetchIsAdmin(this.$axios);
        this.$router.push('/');
      }
    }
  }
});

</script>