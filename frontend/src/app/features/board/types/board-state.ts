import { TaskState } from './task-state';
import { BoardTask } from './board-task';

export interface BoardState {
  [TaskState.ToDo]: BoardTask[];
  [TaskState.InProgress]: BoardTask[];
  [TaskState.Done]: BoardTask[];
}