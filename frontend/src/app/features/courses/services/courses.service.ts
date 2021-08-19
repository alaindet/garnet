import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';
import { map } from 'rxjs/operators';

import { environment } from '@environment/environment';
import { AuthenticationService } from '@app/core/auth/services';
import { Course, GetCoursesResponse, CreateCourseDto, CreateCourseResponse } from '../types';

@Injectable()
export class CoursesService {

  constructor(
    private http: HttpClient,
    private authService: AuthenticationService,
  ) {}

  getAllCourses(): Observable<Course[]> {
    const url = environment.apiUrl + '/courses';

    // TODO: Move into interceptor
    const jwt = this.authService.getToken();
    const headers = new HttpHeaders()
      .set('Authorization', `Bearer ${jwt}`);

    return this.http.get<GetCoursesResponse>(url, { headers })
      .pipe(map(response => response.data))
  }

  createCourse(dto: CreateCourseDto): Observable<Course> {

    const url = environment.apiUrl + '/courses';

    // TODO: Move into interceptor
    const jwt = this.authService.getToken();
    const headers = new HttpHeaders()
      .set('Authorization', `Bearer ${jwt}`);

    return this.http.post<CreateCourseResponse>(url, dto, { headers })
      .pipe(map(response => response.data));
  }
}