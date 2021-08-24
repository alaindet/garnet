import { SuccessResponse } from '@app/core/types';
import { TaskListItem } from './task-list-item';

export type GetTasksResponse = SuccessResponse<TaskListItem[]>;
