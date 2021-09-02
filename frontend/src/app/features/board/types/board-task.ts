import { DateTimeString } from '@app/shared/types';

export interface BoardTask {
  taskId: string | number;
  taskStateId: string | number;
  createdOn: DateTimeString;
  updatedOn: DateTimeString;
  name: string;
  description: string;
}
