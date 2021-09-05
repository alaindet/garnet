export enum TaskState {
  ToDo = 1,
  InProgress = 2,
  Done = 3,
}

export const TASK_STATE = {
  [TaskState.ToDo]: 'To Do',
  [TaskState.InProgress]: 'In Progress',
  [TaskState.Done]: 'Done',
};