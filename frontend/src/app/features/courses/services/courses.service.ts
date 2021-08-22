import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';
import { map } from 'rxjs/operators';

import { environment } from '@environment/environment';
import { AuthenticationService } from '@app/core/auth/services';
import {
  Course,
  GetCoursesResponse,
  GetCourseResponse,
  CreateCourseRequest,
  CreateCourseResponse,
  UpdateCourseRequest,
} from '../types';

@Injectable()
export class CoursesService {

  constructor(
    private http: HttpClient,
    private authService: AuthenticationService,
  ) {}

  getAllCourses(): Observable<Course[]> {
    const url = environment.apiUrl + '/courses';
    const options = this.getCorsOptions();
    return this.http.get<GetCoursesResponse>(url, options)
      .pipe(map(response => response.data))
  }

  getOneCourse(id: string | number): Observable<Course> {
    const url = environment.apiUrl + '/courses/' + id;
    const options = this.getCorsOptions();
    return this.http.get<GetCourseResponse>(url, options)
      .pipe(map(response => response.data))
  }

  createCourse(dto: CreateCourseRequest): Observable<Course> {
    const url = environment.apiUrl + '/courses';
    const options = this.getCorsOptions();
    return this.http.post<CreateCourseResponse>(url, dto, options)
      .pipe(map(response => response.data));
  }

  updateCourse(dto: UpdateCourseRequest): Observable<Course> {
    const url = environment.apiUrl + '/courses/' + dto.id;
    const options = this.getCorsOptions();
    return this.http.patch<GetCourseResponse>(url, dto, options)
      .pipe(map(response => response.data));
  }

  deleteCourse(courseId: number | string): Observable<Course> {
    const url = environment.apiUrl + '/courses/' + courseId;
    const options = this.getCorsOptions();
    return this.http.delete<GetCourseResponse>(url, options)
      .pipe(map(response => response.data));
  }

  // TODO: Move to interceptor
  private getCorsOptions(): { headers: HttpHeaders } {
    const jwt = this.authService.getToken();
    const headers = new HttpHeaders().set('Authorization', `Bearer ${jwt}`);
    return { headers };
  }
}
