<template>
  <LayoutAppHeader />
  <main>
    <section>
      <slot />
    </section>
  </main>
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