<template>
  <LayoutAppHeader />
  <main>
    <section>
      <LayoutBreadcrumb />
      <div class="layout-actions">
        <LayoutBackButton v-show="!isHome"/>
      </div>
      <slot />
    </section>
  </main>
  <LayoutAdmActions v-if="user && user.is_admin" />
  <div class="space">

  </div>
  <LayoutAppFooter />
</template>

<script lang="ts">
import useUserStore from "~/stores/useUserStore";

export default defineComponent({
  name: "DefaultLayout",

  data: () => ({
    user: null as null | ReturnType<typeof useUserStore>,
  }),
  computed:{
    isHome(){
      return useRoute().path === "/"
    }
  },

  mounted() {
    this.user = useUserStore();
  }
});
</script>

<style lang="scss" scoped>
section {
  margin: 8em auto 0 auto;
  width: 60vw;
  overflow-y: auto;
}
.layout-actions{
  display: grid;
  grid-template-columns: auto 1fr;
}.space{
  height: 5em;
 }
</style>