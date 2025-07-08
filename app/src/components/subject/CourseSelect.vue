<template>
  <client-only>
    <AppSelect
      v-model="selected"
      :items="courses"
      labelInput="name"
      placeholder="Pesquise pelo curso"
      id="course"
    />
  </client-only>
</template>

<script lang="ts">
import type { CourseType } from '~/types/Course';
import CourseService from '~/services/CourseService';

export default defineComponent({
  name: 'CourseSelect',

  async setup() {
    const courses = ref<CourseType[]>([]);
    const page = ref<number>(1);
    const last_page = ref<number>(1);

    async function getCourses() {
      const data = await CourseService.fetch(page.value);
      courses.value.push(...data.courses);
      last_page.value = data.last_page;
    }

    getCourses();

    return {
      courses,
      page,
      last_page,
      getCourses,
    };
  },

  props: {
    modelValue: {
      type: Object as PropType<CourseType[]>,
      required: true,
    },
  },

  emits: ['update:modelValue'],

  computed: {
    selected: {
      get(): CourseType[] {
        return this.modelValue;
      },
      set(value: CourseType[]) {
        this.$emit('update:modelValue', value);
      },
    },
  },

  mounted() {
    const moreCourses = async () => {
      if (this.page < this.last_page) {
        this.page++;
        await this.getCourses();
        setTimeout(moreCourses, 300);
      }
    };
    setTimeout(moreCourses, 300);
  },
});
</script>
