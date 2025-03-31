<template>
    <AppInput type="text" v-model="courseSearch" />
    <div class="courses-list-container">
        <div class="courses-list-items" v-for="(course, index) in coursesFiltered" :key="course.id">
            <input
                type="checkbox"
                :id="`course-${course.id}`"
                @input="$event.target?.checked ? selected[index] = course : selected.splice(index, 1)"
            />
            <label :for="`course-${course.id}`">{{ course.name }}</label>
        </div>
    </div>
</template>

<script lang="ts">
import Course from '~/classes/Course';
import CourseService from '~/services/CourseService';

export default defineComponent({
    name: 'CourseSelect',

    async setup() {
        const courses = ref<Course[]>([]);
        const page = ref<number>(1);
        const last_page = ref<number>(1);

        async function getCourses() {
            const data = await CourseService.fetch(page.value);
            courses.value.push(...data.courses);
            last_page.value = data.last_page;
        }
        
        await getCourses();

        return {
            courses,
            page,
            last_page,
            getCourses,
        }
    },

    props: {
        modelValue: {
            type: Array as PropType<Course[]>,
            required: true
        }
    },

    emits: ['update:modelValue'],

    computed: {
        selected: {
            get(): Course[] {
                return this.modelValue;
            },
            set(value: Course[]) {
                this.$emit('update:modelValue', value);
            }
        },
        coursesFiltered(): Course[] {
            return this.courses.filter((course) => {
                if(course.name) {
                    return course.name.toLowerCase().includes(this.courseSearch.toLowerCase());
                } else {
                    return false;
                }
            })
        }
    },

    data: () => ({
        courseSearch: '',
    }),

    mounted() {
        const moreCourses = async () => {
            if(this.page < this.last_page) {
                this.page++;
                await this.getCourses();
                setTimeout(moreCourses, 300);
            }
        }
        setTimeout(moreCourses, 300);
    }
});
</script>


<style scoped lang="scss">
.courses-list-container{
  display: flex;
  flex-direction: column;
  overflow-y: auto;
  height: 10rem;
}
.courses-list-items{
  display: flex;
  flex-direction: row;
  gap:1rem;
}
</style>