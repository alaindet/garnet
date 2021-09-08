import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';
import { map } from 'rxjs/operators';

import { environment } from '@environment/environment';
import { JwtService } from '@app/core/auth/services/jwt.service';
import {
  GetProgressByStudentResponse,
  StudentProgress,
  GetProgressByTaskResponse,
  TaskProgress,
} from '../types';

@Injectable({
  providedIn: 'root',
})
export class ProgressService {

  constructor(
    private http: HttpClient,
    private jwtService: JwtService,
  ) {}

  getCourseProgressByStudent(courseId: string | number): Observable<StudentProgress[]> {
    const url = `${environment.apiUrl}/board/${courseId}/progress/by-student`;
    const options = this.getCorsOptions();
    return this.http.get<GetProgressByStudentResponse>(url, options)
      .pipe(map(response => response.data.students))
  }

  getCourseProgressByTask(courseId: string | number): Observable<TaskProgress[]> {
    const url = `${environment.apiUrl}/board/${courseId}/progress/by-task`;
    const options = this.getCorsOptions();
    return this.http.get<GetProgressByTaskResponse>(url, options)
      .pipe(map(response => response.data.tasks))
  }

  // TODO: Move to interceptor
  private getCorsOptions(): { headers: HttpHeaders } {
    const jwt = this.jwtService.fetchRaw();
    const headers = new HttpHeaders().set('Authorization', `Bearer ${jwt}`);
    return { headers };
  }
}
