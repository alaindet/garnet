import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable, of } from 'rxjs';
import { map } from 'rxjs/operators';

import { environment } from '@environment/environment';
import { JwtService } from '@app/core/auth/services/jwt.service';
import { Task } from '@app/shared/types';
import { GetTasksResponse } from '../../task-manager/types'; // TODO

@Injectable()
export class TasksService {

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

  updateTaskStatusById(taskId: string | number, taskStatus: any): Observable<any> {
    // ...
    return of(null);
  }

  // TODO: Move to interceptor
  private getCorsOptions(): { headers: HttpHeaders } {
    const jwt = this.jwtService.fetchRaw();
    const headers = new HttpHeaders().set('Authorization', `Bearer ${jwt}`);
    return { headers };
  }
}
