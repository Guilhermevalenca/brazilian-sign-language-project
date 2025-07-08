<script setup lang="ts">
import { Bar, Doughnut } from 'vue-chartjs';
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  CategoryScale,
  LinearScale,
  BarElement,
  ArcElement,
} from 'chart.js';
import UserMonitoringService from '~/services/UserMonitoringService';

ChartJS.register(Title, Tooltip, Legend, CategoryScale, LinearScale, BarElement, ArcElement);

interface IAvgPartOfPage {
  part_of_page: string;
  count: number;
}

const { data } = await useAsyncData(
    'fetch-user-monitoring',
    () => UserMonitoringService.fetch(),
    {
      default: () => ({
        avgPartOfPage: [],
      }),
});

onMounted(async () => {
  UserMonitoringService.fetch();
});

const avgPartOfPage = computed((): IAvgPartOfPage[] => {
  if (data.value.avgPartOfPage) {
    const translated = data.value.avgPartOfPage.map(({ part_of_page, count }: IAvgPartOfPage) => {
      let part = '';
      switch (part_of_page) {
        case 'subject':
          part = 'Disciplina';
          break;
        case 'course':
          part = 'Curso';
          break;
        case 'home':
          part = 'Pagina inicial';
          break;
        case 'search':
          part = 'Busca';
          break;
        case 'sign':
          part = 'Sinais';
          break;
        default:
          part = 'Outro';
          break;
      }

      return {
        part_of_page: part,
        count,
      };
    });

    const response = translated.filter((item: IAvgPartOfPage) => item.part_of_page !== 'Outro');
    let totalOther = 0;
    translated.forEach((item: IAvgPartOfPage) => {
      if (item.part_of_page === 'Outro') {
        totalOther += item.count;
      }
    });
    if (totalOther > 0) {
      response.push({
        part_of_page: 'Outro',
        count: totalOther,
      });
    }
    return response;
  }
  return [];
});

const barOptions = {
  responsive: true,
  plugins: {
    legend: { display: false },
    title: { display: true, text: 'Quantidade de acessos por paginas' },
  },
};
</script>

<template>
  <client-only>
    <div class="tw-grid tw-gap-6 tw-lg:grid-cols-2">
      <Bar
        v-if="avgPartOfPage.length > 0"
        :data="{
          labels: avgPartOfPage.map((i) => i.part_of_page),
          datasets: [
            {
              label: 'Quantidade de acessos',
              data: avgPartOfPage.map((i) => i.count),
            },
          ],
        }"
        :options="barOptions"
        class="tw-rounded-2xl tw-shadow tw-p-4"
      />
    </div>
  </client-only>
</template>
