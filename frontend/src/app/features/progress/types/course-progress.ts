import { TaskState } from '@app/features/board/types';

export interface StudentProgress {
  student: {
    studentId: string | number;
    firstName: string;
    lastName: string;
  };
  taskCounters: {
    [TaskState.ToDo]: number;
    [TaskState.InProgress]: number;
    [TaskState.ToDo]: number;
  }
}

export interface TaskProgress {
  task: {
    taskId: string | number;
    name: string;
    description: string;
  }
  studentCounters: {
    [TaskState.ToDo]: number;
    [TaskState.InProgress]: number;
    [TaskState.ToDo]: number;
  }
}

export interface CourseProgress {
  byStudent: StudentProgress[];
  byTask: TaskProgress[];
}
