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
main {
  width: 100vw;
}

section {
  display: block;
  margin: 0 auto;
  width: 60vw;
  margin-top: 8em;

  position: relative;
  z-index: 100;
}
</style>