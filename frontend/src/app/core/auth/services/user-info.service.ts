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
export class UserInfoService {

  USER_KEY = `${environment.appSlug}.user`;

  getJwt(): string | null {
    const userItem = localStorage.getItem(this.USER_KEY);
    if (userItem === null) return null;
    const userInfo = JSON.parse(userItem) as StoredUserInfo;
    return userInfo?.jwt ?? null;
  }

  getDecodedInfoFromJwt(): JwtDecodedInfo | null {
    try {
      const jwt = this.getJwt();
      if (jwt === null) return null;
      return jwt_decode(jwt);
    } catch (error) {
      return null;
    }
  }

  getUserRole(): number | null {
    const info = this.getDecodedInfoFromJwt();
    if (info === null) return null;
    const roleClaim = `${environment.appSlug}.role`;
    return asNumber(info[roleClaim]);
  }

  private isTokenExpired(jwt: string): boolean {
    const expiration = parseInt(parseJwt(jwt).exp) * 1000;
    const now = Date.now();
    return now >= expiration;
  }
}
