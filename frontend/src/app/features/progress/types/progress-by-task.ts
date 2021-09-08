import { SuccessResponse } from '@app/core/types';

export interface TaskProgress {
  taskId: number;
  taskName: string;
  taskDescription: string;
  studentsToDo: number;
  studentsInProgress: number;
  studentsDone: number;
}

export type GetProgressByTaskResponse = SuccessResponse<{
  tasks: TaskProgress[];
}>;
