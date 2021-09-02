import { SuccessResponse } from '@app/core/types';
import { BoardTask } from './board-task';

export type GetBoardTasksResponse = SuccessResponse<BoardTask[]>;
