import { Injectable } from '@angular/core';
import jwt_decode from 'jwt-decode';

import { environment } from '@environment/environment';
import { LocalStorageService } from '@app/core/services';
import { asNumber } from '@app/shared/utils';
import { JwtDecodedInfo } from '../types';

@Injectable({
  providedIn: 'root',
})
export class JwtService {

  private storageKey = `${environment.appSlug}.jwt`;

  constructor(private localStorageService: LocalStorageService) {
    this.localStorageService.register(this.storageKey, this.jwtParser);
  }

  clear(): void {
    this.localStorageService.clearItem(this.storageKey);
  }

  private jwtParser(jwt: string | null): JwtDecodedInfo | null {
    try {
      return (jwt !== null) ? jwt_decode(jwt) : null;
    } catch (error) {
      return null;
    }
  }


  // decode(): JwtDecodedInfo | null {
  //   try {
  //     const jwt = this.fetch();

  //     if (jwt === null) {
  //       return null;
  //     }

  //     return jwt_decode(jwt);
  //   } catch (error) {
  //     return null;
  //   }
  // }

  // hasExpired(prefetchedInfo: JwtDecodedInfo | null = null): boolean {

  //   const info = prefetchedInfo ?? this.decode();

  //   if (info === null) {
  //     return true;
  //   }

  //   const expiration = asNumber(info.exp) * 1000;
  //   const now = Date.now();

  //   return now >= expiration;
  // }
}
