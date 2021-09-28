import { SuccessResponse } from '@app/core/types';

export interface CourseSearchItem {
  course_id: string | number;
  name: string;
}

export type GetCoursesByNameResponse = SuccessResponse<CourseSearchItem[]>;
