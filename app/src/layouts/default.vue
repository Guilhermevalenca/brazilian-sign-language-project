<template>
  <LayoutAppHeader />
  <main>
    <section>
      <LayoutBreadcrumb />
      <slot />
    </section>
  </main>
  <LayoutAdmActions />
  <LayoutAppFooter />
</template>

<style lang="scss" scoped>
section {
  margin: 0 auto;
  width: 60vw;
  margin-top: 8em;
  overflow-y: auto;
}
</style>