type AvgPartOfPageType = {
  part_of_page: string;
  average_daily: number;
  color: string;
};

type UserMonitoringDto = {
  part_of_page: string;
  token: string | null;
  timestamp: string | Date;
};

export type { AvgPartOfPageType, UserMonitoringDto };
