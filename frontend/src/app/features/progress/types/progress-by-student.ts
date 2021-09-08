import { SuccessResponse } from '@app/core/types';

export interface StudentProgress {
  userId: number;
  firstName: string;
  lastName: string;
  tasksToDo: number;
  tasksInProgress: number;
  tasksDone: number;
}

export type GetProgressByStudentResponse = SuccessResponse<{
  students: StudentProgress[];
}>;
