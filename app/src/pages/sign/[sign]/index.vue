<template>
    <div class="update-container" v-if="userStore.is_admin">
      <AppButton
          @click="() => navigateTo('/sign/' + sign.id + '/update')"
      >
        <img src="~/assets/icons/edit.svg" width="24px" height="24px">
        Editar
      </AppButton>
      <AppButton @click="deleteSign">
        <img src="~/assets/icons/delete.svg" width="24px" height="24px">
        Apagar
      </AppButton>
  </div>
  <div class="content-container">
    <transition name="slide">
      <div class="views-menu">
        <div
          @click="currentComponent = 'SignView'"
          :class="{ active: currentComponent === 'SignView' }"
          role="button"
          tabindex="1"
        >
          Sinal
        </div>

        <div
          @click="currentComponent = 'SignDescriptionView'"
          :class="{ active: currentComponent === 'SignDescriptionView' }"
          role="button"
          tabindex="1"
        >
          Descrição do sinal
        </div>

        <div
          @click="currentComponent = 'SignExampleView'"
          :class="{ active: currentComponent === 'SignExampleView' }"
          role="button"
          tabindex="1"
        >
          Exemplo de uso
        </div>
      </div>
    </transition>
    <AppCard variant="screen" class="abacate">
      <keep-alive>
        <component :is="currentComponent" :sign="sign" />
      </keep-alive>
    </AppCard>
  </div>
</template>

<script lang="ts">
import SignService from '~/services/SignService';
import useBreadcrumbStore from '~/stores/useBreadcrumbStore';
import type { SignType } from '~/types/Sign';
import LoadingService from '~/services/LoadingService';
import { SignDescriptionView } from '#components';
import { SignExampleView } from '#components';
import SignView from '~/components/sign/SignView.vue';
import useUserStore from '~/stores/useUserStore';

export default defineComponent({
  name: 'signPage',
  components: { SignDescriptionView, SignExampleView, SignView },
  async setup() {
    const currentComponent = ref('SignView');
    const { sign: id } = useRoute().params;

    const { data, status, execute, refresh } = useAsyncData(
      'fetchSign',
      () => SignService.find(Number(id)),
      {
        default: () => ({
          sign: {
            name: '',
            display: '',
          },
        }),
        immediate: false,
        lazy: true,
      },
    );
    onBeforeMount(() => {
      LoadingService.show();
      setTimeout(() => {
        LoadingService.loaded(status.value, refresh);
      }, 300);
    });

    watch(status, ($new) => {
      LoadingService.loaded($new, refresh);
    });

    try {
      execute();
    } catch (e) {
      console.log(e);
    }

    return {
      sign: computed((): SignType => data.value.sign as SignType),
      currentComponent,
      id,
      userStore: useUserStore(),
    };
  },

  methods: {
    async deleteSign() {
      const { $swal } = useNuxtApp();
      try {
        $swal.fire({
          title: 'Deletando sinal...',
        });
        $swal.showLoading();
        await SignService.delete(Number(this.id));
        await $swal.fire({
          icon: 'success',
          title: 'Sinal deletado com sucesso',
          timer: 10000,
          showConfirmButton: true,
          confirmButtonText: 'OK',
        });
        navigateTo('/');
      } catch (e) {
        await $swal.fire({
          icon: 'error',
          title: 'Algo deu errado',
          text: 'Ocorreu um erro, gostaria de tentar novamente ?',
          timer: 3000,
          showConfirmButton: true,
          confirmButtonText: 'Tentar novamente',
        });
      }
    },
  },

  watch: {
    'sign.name': {
      handler($new) {
        useBreadcrumbStore().activeSign($new ?? '', '/sign/' + this.id);
      },
      deep: true,
      immediate: true,
    },
  },
});
</script>
<style lang="scss" scoped>
.views-menu {
  flex-flow: row nowrap;
  justify-content: space-around;
  border-top-right-radius: 1em;
  border-top-left-radius: 1em;
  width: 100%;
  height: 3em;
  display: flex;
  background-color: $primary-color;
  div {
    display: flex;
    flex-flow: row wrap;
    justify-content: center;
    align-content: center;
    width: 100%;
    height: 100%;
    color: $light-texts;
    border-top-right-radius: 1em;
    border-top-left-radius: 1em;
    cursor: pointer;
    user-select: none;
  }
  div:hover {
    justify-self: center;
    transform: scale(1, 1);
    background-color: $primary-color-hovered;
  }
  div.active {
    background-color: $tertiary-color;
    border-top: solid 3px $primary-color-hovered;
    color: $soft-black-1;
  }
}
.abacate {
  width: 50vw;
  border-top-right-radius: 0em;
  border-top-left-radius: 0em;
  padding: 2em;
}
.slide-enter-active,
.slide-leave-active {
  transition: all 0.3s ease;
}
.slide-enter-from,
.slide-leave-to {
  transform: translateY(-20px);
  opacity: 0;
}
.update-container {
  display: flex;
  flex-flow: column nowrap;
  margin-right: 2em;
  align-items: flex-end;
  padding: 0.5em;
}
</style>
