import { TaskState } from '@app/features/board/types';

export interface ProgressItem {
  task_id: string | number;
  user_id: string | number;
  task_state_id: TaskState;
}
