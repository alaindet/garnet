import { SuccessResponse } from '@app/core/types';
import { Task } from './task';

export type GetTasksResponse = SuccessResponse<Task[]>;
