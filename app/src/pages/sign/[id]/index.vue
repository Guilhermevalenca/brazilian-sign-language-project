<template>
  <button @click="navigateTo(`/sign/${sign?.id}/update`)">Atualizar</button>
  <br />
  <button @click="destroy">deletar ou apagar</button>
  <span class="tw-text-xs">*Esta opção apagará o contéudo para sempre</span>
  <br />
  <div class="content-container">
    <transition-group name="contents">
      <div class="views-menu">
        <div
            @click="currentComponent = 'SignView'"
            :class="{ active: currentComponent === 'SignView' }"
            role="button"
            tabindex="1"
        >Sinal
        </div>

        <div
            @click="currentComponent = 'SignDescriptionView'"
            :class="{ active: currentComponent === 'SignDescriptionView' }"
            role="button"
            tabindex="1"
        >Descrição do sinal
        </div>

        <div
            @click="currentComponent = 'SignExampleView'"
            :class="{ active: currentComponent === 'SignExampleView' }"
            role="button"
            tabindex="1"
        >Exemplo de uso
        </div>

      </div>
    </transition-group>
    <AppCard variant="default" class="abacate">
      <component :is="currentComponent" :sign="sign"
      />
    </AppCard>

  </div>
  </template>

<script lang="ts">

import SignService from '~/services/SignService';
import useBreadcrumbStore from '~/stores/useBreadcrumbStore';
import type { SignType } from '~/types/Sign';
import SubjectService from "~/services/SubjectService";
import LoadingService from "~/services/LoadingService";
import {SignDescriptionView} from "#components";
import {SignExampleView} from "#components";
import SignView from "~/components/sign/SignView.vue";

export default defineComponent({
  name: 'signPage',
  components: {SignDescriptionView,SignExampleView,SignView},
  async setup() {
    const currentComponent= ref('SignView');
    const { id } = useRoute().params;

    const { data, status, execute, refresh } = useAsyncData(
        'fetchSubject',
        () => SignService.find(Number(id)),
        {
          default: () => ({
            sign: {
              name: '',
              display: '',
            }
          })
        }
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
      id
    }
  },

  methods: {
    async destroy() {
      try {
        this.$swal.fire({
          icon: 'info',
          title: 'Deletando sinal...',
        });
        this.$swal.showLoading();
        await SignService.delete(Number(this.id));
        await this.$swal.fire({
          icon: 'success',
          title: 'Sinal deletado com sucesso',
          timer: 10000,
          showConfirmButton: true,
          confirmButtonText: 'OK',
        });
        navigateTo(-1);
      } catch(e) {
        console.log(e);
      }
    },
  },

  watch: {
    "sign.name": {
      handler($new) {
        useBreadcrumbStore().activeSign($new ?? '', '/sign/' + this.id);
      },
      deep: true,
      immediate: true,
    }
  }
});
</script>
<style lang="scss" scoped>
.views-menu{
  flex-flow: row nowrap;
  justify-content: space-around;
  border-top-right-radius: 1em;
  border-top-left-radius: 1em;
  width: 100%;
  height: 3em;
  display: flex;
  background-color: $primary-color;
  div{
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
  }
  div.active{
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
.contents-enter-active,
.contents-leave-active {
  transition: all 0.5s ease;
}
.contents-enter-from,
.contents-leave-to {
  opacity: 0;
  transform: translateX(30px);
}
</style>