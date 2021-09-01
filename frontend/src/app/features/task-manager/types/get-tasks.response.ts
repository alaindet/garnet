import { SuccessResponse } from '@app/core/types';
import { Task } from '@app/shared/types';

export type GetTasksResponse = SuccessResponse<Task[]>;
