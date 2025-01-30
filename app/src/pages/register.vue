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
import UserService from '~/services/UserService';
import useUserStore from '~/stores/useUserStore';

export default defineComponent({
  name: "register",

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
      await new UserService(this.user)
          .register(this.$axios)
          .then((res) => {
            if(res) {
              useUserStore().data.sync(this.user);
              alert('success');
              this.$router.push('/');
            }
          })
    }
  },
});

</script>