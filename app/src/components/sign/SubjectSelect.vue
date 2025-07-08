<template>
  <client-only>
    <AppSelect
      v-model="selected"
      :items="subjects"
      labelInput="name"
      placeholder="Pesquise pela materia"
      id="subject"
    />
  </client-only>
</template>

<script lang="ts">
import type { SubjectType } from '~/types/Subject';
import SubjectService from '~/services/SubjectService';

export default defineComponent({
  name: 'SubjectSelect',

  async setup() {
    const subjects = ref<SubjectType[]>([]);
    const page = ref<number>(1);
    const last_page = ref<number>(1);

    async function getSubjects() {
      const data = await SubjectService.fetch(page.value);
      subjects.value.push(...data.subjects);
      last_page.value = data.last_page;
    }

    getSubjects();

    return {
      subjects,
      page,
      last_page,
      getSubjects,
    };
  },

  props: {
    modelValue: {
      type: Object as PropType<SubjectType[]>,
      required: true,
    },
  },

  emits: ['update:modelValue'],

  computed: {
    selected: {
      get(): SubjectType[] {
        return this.modelValue;
      },
      set(value: SubjectType[]) {
        this.$emit('update:modelValue', value);
      },
    },
  },

  mounted() {
    const moreSubjects = async () => {
      if (this.page < this.last_page) {
        this.page++;
        await this.getSubjects();
        setTimeout(moreSubjects, 300);
      }
    };
    setTimeout(moreSubjects, 300);
  },
});
</script>

<style scoped lang="scss"></style>
