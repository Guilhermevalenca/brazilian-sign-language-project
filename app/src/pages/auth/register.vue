<template>
<form @submit.prevent="submit">
  <input v-model="user.name" placeholder="Name" />
  <br />
  <input v-model="user.email" placeholder="Email" />
  <br />
  <input v-model="user.password" placeholder="Password" />
  <br />
  <input v-model="user.password_confirmation" placeholder="Confirmation Password" />
  <br />
  <button type="submit">register</button>
</form>
</template>

<script lang="ts">
import User from "~/classes/User";
import useUserStore from '~/stores/useUserStore';
import {type AxiosError, type AxiosResponse} from "axios";

export default defineComponent({
  name: "register",

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
        const res = await this.user.register(this.$axios);
        if(typeof res === 'object' && 'data' in res) {
          const token = res.data.token;
          this.$axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
          localStorage.setItem('token', token);

          const tokenCookie = useCookie('token');
          tokenCookie.value = token;

          await useUserStore().data.fetch(this.$axios);
          await useUserStore().fetchIsAdmin(this.$axios);
          this.$router.push('/auth/check-email-code');
        }
      } catch (e: AxiosResponse | AxiosError | any) {
        console.log(e);
      }
    }
  },
});

</script>