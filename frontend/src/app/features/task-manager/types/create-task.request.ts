export interface CreateTaskRequest {
  courseId: string | number;
  name: string;
  description?: string;
}
