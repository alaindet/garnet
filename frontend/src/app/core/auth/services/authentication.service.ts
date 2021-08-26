import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { tap } from 'rxjs/operators';
import jwt_decode from 'jwt-decode';

import { environment } from '@environment/environment';
import { parseJwt } from '@app/shared/utils';
import { SignInDto, SignInResponse, StoredUserInfo, JwtDecodedInfo } from '../types';
import { Response } from '@app/shared/types';

@Injectable({
  providedIn: 'root',
})
export class AuthenticationService {

  USER_KEY = `${environment.appSlug}.user`;

  constructor(
    private http: HttpClient,
  ) {}

  signIn(dto: SignInDto): Observable<Response<SignInResponse>> {
    const url = environment.apiUrl + '/auth/signin';
    return this.http.post<Response<SignInResponse>>(url, dto)
      .pipe(tap(res => {
        localStorage.setItem(this.USER_KEY, JSON.stringify(res.data));
      }));
  }

  signOut(): void {
    localStorage.removeItem(this.USER_KEY);
  }

  isSignedIn(): boolean {

    const userItem = localStorage.getItem(this.USER_KEY);

    if (userItem === null) {
      return false;
    }

    const userInfo = JSON.parse(userItem) as StoredUserInfo;

    if (!userInfo?.jwt) {
      return false;
    }

    if (this.isTokenExpired(userInfo.jwt)) {
      return false;
    }

    return true;
  }

  getToken(): string | null {

    const userItem = localStorage.getItem(this.USER_KEY);

    if (userItem === null) {
      return null;
    }

    const userInfo = JSON.parse(userItem) as StoredUserInfo;

    return userInfo?.jwt ?? null;
  }

  getDecodedToken(): JwtDecodedInfo | null {
    try {
      const userInfoRaw = localStorage.getItem(this.USER_KEY);

      if (userInfoRaw === null) {
        return null;
      }

      const userInfo = JSON.parse(userInfoRaw);
      const token = userInfo.jwt;
      return jwt_decode(token);
    } catch (error) {
      console.error(error);
      return null;
    }
  }

  private isTokenExpired(jwt: string): boolean {
    const expiration = parseInt(parseJwt(jwt).exp) * 1000;
    const now = Date.now();
    return now >= expiration;
  }
}
