import { DateTimeString } from '@app/shared/types';

export interface Course {
  course_id: number;
  teacher_id: number;
  created_on: DateTimeString;
  updated_on: DateTimeString;
  name: string;
  description: string;
}