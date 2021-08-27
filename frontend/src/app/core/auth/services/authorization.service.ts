import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { tap } from 'rxjs/operators';
import jwt_decode from 'jwt-decode';

import { environment } from '@environment/environment';
import { parseJwt, asNumber } from '@app/shared/utils';
import { SignInDto, SignInResponse, StoredUserInfo, JwtDecodedInfo } from '../types';
import { Response } from '@app/shared/types';

@Injectable({
  providedIn: 'root',
})
export class AuthorizationService {

  USER_KEY = `${environment.appSlug}.user`;

  constructor(
    private http: HttpClient,
  ) {}

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

  getUserRole(): number | null {
    const decodedToken = this.getDecodedToken();

    if (decodedToken === null) {
      return null;
    }

    const roleClaim = `${environment.appSlug}.role`;
    return asNumber(decodedToken[roleClaim]);
  }

  private isTokenExpired(jwt: string): boolean {
    const expiration = parseInt(parseJwt(jwt).exp) * 1000;
    const now = Date.now();
    return now >= expiration;
  }
}
