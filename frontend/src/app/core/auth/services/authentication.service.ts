import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { tap } from 'rxjs/operators';

import { environment } from '@environment/environment';
import { SignInDto, SignInResponse } from '../types';
import { Response } from '@app/shared/types';

@Injectable({
  providedIn: 'root',
})
export class AuthenticationService {

  USER_KEY = 'garnet.user';

  constructor(
    private http: HttpClient,
  ) {}

  signIn(dto: SignInDto): Observable<Response<SignInResponse>> {
    const url = environment.apiUrl + '/auth/signin';
    return this.http.post<Response<SignInResponse>>(url, dto)
      .pipe(tap(res => {
        console.log('AuthenticationService.signIn', res);
        localStorage.setItem(this.USER_KEY, JSON.stringify(res.data));
      }));
  }

  isSignedIn(): boolean {
    const userItem = localStorage.getItem(this.USER_KEY);

    if (userItem === null) {
      return false;
    }

    const user = JSON.parse(userItem) as SignInResponse;

    if (!user?.jwt) {
      return false;
    }

    return true;
  }
}