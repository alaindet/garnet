export interface UpdateTaskRequest {
  courseId: string | number;
  taskId: string | number;
  name?: string;
  description?: string;
}
