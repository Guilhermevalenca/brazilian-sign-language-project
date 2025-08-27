<template>
  <LayoutAppHeader />
  <LayoutMenu />
  <main>
    <section>
      <LayoutBreadcrumb />
      <div class="layout-actions">
        <LayoutBackButton v-show="!isHome" />
      </div>
      <slot />
    </section>
  </main>
  <LayoutAdmActions v-if="user && user.is_admin" />
  <div class="space" />
  <LayoutAppFooter />
</template>

<script setup lang="ts">
import useUserStore from '~/stores/useUserStore';
import UserMonitoringService from '~/services/UserMonitoringService';

const user = useUserStore();
const isHome = computed(() => useRoute().path === '/');

const route = useRoute();

async function sendMonitoring() {
  let path = route.path;
  if (path === '/') {
    path = 'home';
  } else if (path.startsWith('/auth')) {
    path = 'auth';
  }
  if (!path.startsWith('/monitoring')) {
    UserMonitoringService.register(path);
  }
}

onMounted(() => {
  setInterval(async () => {
    sendMonitoring();
  }, 5000);
});
</script>

<style lang="scss" scoped>
@media (max-width: 576px) {
  main {
    margin: 8rem auto 0 auto;
    width: 90vw;
  }
}
main {
  margin: 8rem auto 0 auto;
  width: 70vw;
}
.layout-actions {
  display: grid;
  grid-template-columns: auto 1fr;
}
.space {
  height: 5rem;
}
</style>
