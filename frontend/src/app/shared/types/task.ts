import { DateTimeString } from './datetime-string';

export interface Task {
  task_id: number | string;
  course_id: number | string;
  created_on: DateTimeString;
  updated_on: DateTimeString;
  name: string;
  description: string;
}
