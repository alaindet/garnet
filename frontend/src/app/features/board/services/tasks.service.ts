import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable, of } from 'rxjs';
import { map } from 'rxjs/operators';

import { environment } from '@environment/environment';
import { JwtService } from '@app/core/auth/services/jwt.service';
import { BoardTask, GetBoardTasksResponse } from '../types';

@Injectable()
export class TasksService {

  constructor(
    private http: HttpClient,
    private jwtService: JwtService,
  ) {}

  getBoardTasks(courseId: string | number): Observable<BoardTask[]> {
    const url = `${environment.apiUrl}/board/${courseId}`;
    const options = this.getCorsOptions();
    return this.http.get<GetBoardTasksResponse>(url, options)
      .pipe(map(response => response.data))
  }

  updateTaskStateById(
    courseId: string | number,
    taskId: string | number,
    taskStateId: any,
  ): Observable<any> {
    const baseUrl = environment.apiUrl;
    const url = `${baseUrl}/board/${courseId}/tasks/${taskId}`
    const body = { taskStateId };
    const options = this.getCorsOptions();
    return this.http.put<any>(url, body, options)
      .pipe(map(response => response.data));
  }

  // TODO: Move to interceptor
  private getCorsOptions(): { headers: HttpHeaders } {
    const jwt = this.jwtService.fetchRaw();
    const headers = new HttpHeaders().set('Authorization', `Bearer ${jwt}`);
    return { headers };
  }
}
