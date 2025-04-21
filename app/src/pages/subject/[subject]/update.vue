<template>
  <AppCard>
    <div>
      <h1>Atualizar Materia</h1>
    </div>
    <AppForm @submit.prevent="submit">
      <div>
        <label>
          Nome:
          <AppInput
              type="text"
              placeholder="Digite o nome da matéria"
              name="subject.name"
              v-model="subject.name"
          />
        </label>
      </div>
      <div>
        <legend>Selecionar cursos:</legend>
        <SubjectCourseSelect
            v-model="subject.courses"
        />
      </div>

      <legend>Palavras-chave</legend>
      <KeywordSelect
          v-model="subject.keywords"
      />
      <AppButton type="submit">Atualizar Materia</AppButton>
    </AppForm>
  </AppCard>
</template>

<script lang="ts">
import SubjectService from "~/services/SubjectService";
import type {SubjectType} from "~/types/Subject";
import LoadingService from "~/services/LoadingService";

export default defineComponent({
  name: "update",

  async setup() {
    const { subject } = useRoute().params;

    const { data, status, execute, refresh } = useAsyncData(
        'fetchSubject',
        () => SubjectService.edit(Number(subject)),
        {
          default: () => ({
            subject: {
              id: Number(subject),
              name: '',
              courses: [],
              keywords: [],
            } as SubjectType
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

    execute();

    return {
      subject: computed(() => data.value.subject),
      id: Number(subject),
    }
  },

  methods: {
    async submit() {
      try {
        this.$swal.fire({
          icon: 'info',
          title: 'Atualizando disciplina...',
        });
        this.$swal.showLoading();
        await SubjectService.update(this.subject, Number(this.id));
        await this.$swal.fire({
          icon: 'success',
          title: 'Disciplina atualizada com sucesso',
          timer: 10000,
          showConfirmButton: true,
          confirmButtonText: 'OK',
        });
        navigateTo('/');
      } catch (e) {
        this.$swal.fire({
          icon: 'error',
          title: 'Algo deu errado',
          text: 'Ocorreu um erro, gostaria de tentar novamente ?',
          timer: 10000,
          showConfirmButton: true,
          confirmButtonText: 'OK',
        });
      }
    }
  }
})
</script>

<style scoped lang="scss">

</style>