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
import UserService from "~/services/UserService";
import useUserStore from '~/stores/useUserStore';

export default defineComponent({
  name: "login",

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
        await new UserService(useUserStore().data)
            .fetch(this.$axios);
        this.$router.push('/');
      }
    }
  }
});

</script>