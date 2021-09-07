import { SuccessResponse } from '@app/core/types';
import { ProgressItem } from './progress-item';

export type GetCourseProgressResponse = SuccessResponse<ProgressItem[]>;
