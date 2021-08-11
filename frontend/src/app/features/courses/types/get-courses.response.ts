import { SuccessResponse } from '@app/core/types';
import { Course } from './course';

export type GetCoursesResponse = SuccessResponse<Course[]>;