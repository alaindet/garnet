import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';
import { map } from 'rxjs/operators';

import { environment } from '@environment/environment';
import { JwtService } from '@app/core/auth/services/jwt.service';
import { Task } from '@app/shared/types';
import {
  GetTasksResponse,
  GetTaskResponse,
  CreateTaskRequest,
  UpdateTaskRequest,
  DeleteTaskRequest,
} from '../types';

@Injectable()
export class TaskManagerService {

  constructor(
    private http: HttpClient,
    private jwtService: JwtService,
  ) {}

  getTasksByCourseId(courseId: string | number): Observable<Task[]> {
    const url = `${environment.apiUrl}/courses/${courseId}/tasks`;
    const options = this.getCorsOptions();
    return this.http.get<GetTasksResponse>(url, options)
      .pipe(map(response => response.data))
  }

  getTaskById(courseId: string | number, taskId: string | number): Observable<Task> {
    const url = `${environment.apiUrl}/courses/${courseId}/tasks/${taskId}`;
    const options = this.getCorsOptions();
    return this.http.get<GetTaskResponse>(url, options)
      .pipe(map(response => response.data))
  }

  createTask(dto: CreateTaskRequest): Observable<Task> {
    const { courseId, ...requestDto } = dto;
    const url = `${environment.apiUrl}/courses/${courseId}/tasks`;
    const options = this.getCorsOptions();
    return this.http.post<GetTaskResponse>(url, requestDto, options)
      .pipe(map(response => response.data));
  }

  updateTask(dto: UpdateTaskRequest): Observable<Task> {
    const { courseId, taskId, ...requestDto } = dto;
    const url = `${environment.apiUrl}/courses/${courseId}/tasks/${taskId}`;
    const options = this.getCorsOptions();
    return this.http.patch<GetTaskResponse>(url, requestDto, options)
      .pipe(map(response => response.data));
  }

  deleteTask(dto: DeleteTaskRequest): Observable<Task> {
    const { courseId, taskId } = dto;
    const url = `${environment.apiUrl}/courses/${courseId}/tasks/${taskId}`;
    const options = this.getCorsOptions();
    return this.http.delete<GetTaskResponse>(url, options)
      .pipe(map(response => response.data));
  }

  // TODO: Move to interceptor
  private getCorsOptions(): { headers: HttpHeaders } {
    const jwt = this.jwtService.fetchRaw();
    const headers = new HttpHeaders().set('Authorization', `Bearer ${jwt}`);
    return { headers };
  }
}
