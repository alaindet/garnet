import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';
import { map } from 'rxjs/operators';

import { environment } from '@environment/environment';
import { AuthenticationService } from '@app/core/auth/services';
import { TaskListItem, GetTasksResponse } from '../types';

@Injectable()
export class TaskManagerService {

  constructor(
    private http: HttpClient,
    private authService: AuthenticationService,
  ) { }

  public getTasksByCourseId(courseId: string | number): Observable<TaskListItem[]> {
    const url = `${environment.apiUrl}/courses/${courseId}/tasks`;
    const options = this.getCorsOptions();
    return this.http.get<GetTasksResponse>(url, options)
      .pipe(map(response => response.data))
  }

  // TODO: Move to interceptor
  private getCorsOptions(): { headers: HttpHeaders } {
    const jwt = this.authService.getToken();
    const headers = new HttpHeaders().set('Authorization', `Bearer ${jwt}`);
    return { headers };
  }
}
