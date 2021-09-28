import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';
import { map } from 'rxjs/operators';

import { JwtService } from '@app/core/auth/services/jwt.service';
import { environment } from '@environment/environment';
import { CheckInviteTokenResponse, CourseSearchItem, GetCoursesByNameResponse } from '../types';

@Injectable()
export class InviteService {

  constructor(
    private http: HttpClient,
    private jwtService: JwtService,
  ) {}

  checkInviteToken(token: string): Observable<boolean> {
    const url = `${environment.apiUrl}/invite/check`;
    const body = { token };
    const options = this.getCorsOptions();
    return this.http.post<CheckInviteTokenResponse>(url, body, options)
      .pipe(map(response => response.data));
  }

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
