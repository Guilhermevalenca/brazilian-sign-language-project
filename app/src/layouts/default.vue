<template>
  <client-only>
    <LazyAppHeader />
  </client-only>
  <main class="tw-w-screen tw-flex tw-justify-center tw-items-center">
    <section>
      <slot />
    </section>
  </main>
  <client-only>
    <LazyAppFooter />
  </client-only>
</template>


<style scoped>
main {
  min-height: calc(100vh * 60 / 100);
}
section {
  width: 60%;
}
</style>