import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';
import { map } from 'rxjs/operators';

import { environment } from '@environment/environment';
import { JwtService } from '@app/core/auth/services/jwt.service';
import { GetCourseProgressResponse } from '../types';

@Injectable()
export class ProgressService {

  constructor(
    private http: HttpClient,
    private jwtService: JwtService,
  ) {}

  getCourseProgress(courseId: string | number): Observable<any[]> {
    const url = `${environment.apiUrl}/courses`;
    const options = this.getCorsOptions();
    return this.http.get<GetCourseProgressResponse>(url, options)
      .pipe(map(response => response.data))
  }

  // TODO: Move to interceptor
  private getCorsOptions(): { headers: HttpHeaders } {
    const jwt = this.jwtService.fetchRaw();
    const headers = new HttpHeaders().set('Authorization', `Bearer ${jwt}`);
    return { headers };
  }
}
