import { Injectable } from '@angular/core';
import jwt_decode from 'jwt-decode';

import { environment } from '@environment/environment';
import { asNumber } from '@app/shared/utils';
import { JwtDecodedInfo } from '../types';

@Injectable({
  providedIn: 'root',
})
export class JwtService {

  USER_KEY = `${environment.appSlug}.user`;

  store(jwt: string): void {
    localStorage.setItem(this.USER_KEY, jwt);
  }

  fetch(): string | null {
    return localStorage.getItem(this.USER_KEY);
  }

  decode(): JwtDecodedInfo | null {
    try {
      const jwt = this.fetch();

      if (jwt === null) {
        return null;
      }

      return jwt_decode(jwt);
    } catch (error) {
      return null;
    }
  }

  isExpired(prefetchedInfo: JwtDecodedInfo | null = null): boolean {

    const info = prefetchedInfo ?? this.decode();

    if (info === null) {
      return true;
    }

    const expiration = asNumber(info.exp) * 1000;
    const now = Date.now();

    return now >= expiration;
  }
}
