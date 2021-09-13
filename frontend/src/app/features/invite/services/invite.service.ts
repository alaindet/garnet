import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';
import { map } from 'rxjs/operators';

import { JwtService } from '@app/core/auth/services/jwt.service';
import { UserProfile, GetUserProfileResponse } from '@app/features/profile/types';
import { environment } from '@environment/environment';
import { CourseSearchItem, GetCoursesByNameResponse } from '../types';

@Injectable()
export class InviteService {

  constructor(
    private http: HttpClient,
    private jwtService: JwtService,
  ) {}

  // getProfile(): Observable<UserProfile> {
  //   const url = `${environment.apiUrl}/profile`;
  //   const options = this.getCorsOptions();
  //   return this.http.get<GetUserProfileResponse>(url, options)
  //     .pipe(map(response => response.data));
  // }

  searchCoursesByName(name: string): Observable<CourseSearchItem[]> {
    const url = `${environment.apiUrl}/courses/search/by-name`;
    const params = { name };
    const options = { params, ...this.getCorsOptions() };
    return this.http.get<GetCoursesByNameResponse>(url, options)
      .pipe(map(response => response.data));
  }

  // TODO: Move to interceptor
  private getCorsOptions(): { headers: HttpHeaders } {
    const jwt = this.jwtService.fetchRaw();
    const headers = new HttpHeaders().set('Authorization', `Bearer ${jwt}`);
    return { headers };
  }
}
