import type { AvgPartOfPageType, UserMonitoringDto } from '~/types/UserMonitoring';
import { Adapter } from './Adapter';

export class UserMonitoringAdapter extends Adapter<AvgPartOfPageType, UserMonitoringDto> {
  toType({ part_of_page, average_daily }: Partial<AvgPartOfPageType>): AvgPartOfPageType {
    let part = '';
    let color = '';

    switch (part_of_page) {
      case 'home':
        part = 'Página inicial';
        color = '#1976D2';
        break;
      case 'course':
        part = 'Cursos';
        color = '#43A047';
        break;
      case 'subject':
        part = 'Disciplinas';
        color = '#8E24AA';
        break;
      case 'sign':
        part = 'Sinais';
        color = '#E53935';
        break;
      case 'search':
        part = 'Busca';
        color = '#FBC02D';
        break;
      default:
        part = 'Outro';
        color = '#546E7A';
    }

    return {
      part_of_page: part,
      average_daily: Math.round(Number(average_daily)),
      color,
    };
  }

  toDto(data: Partial<AvgPartOfPageType>): UserMonitoringDto {
    if (!data.part_of_page && data.part_of_page?.trim() === '') {
      throw new Error('Part of page is required');
    }

    return {
      part_of_page: String(data.part_of_page),
      token: localStorage.getItem('token_monitoring'),
      timestamp: new Date().toISOString().slice(0, 19).replace('T', ' '),
    };
  }
}
