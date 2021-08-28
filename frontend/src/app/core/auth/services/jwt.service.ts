import { Injectable } from '@angular/core';
import jwt_decode from 'jwt-decode';

import { environment } from '@environment/environment';
import { LocalStorageService } from '@app/core/services';
import { asNumber } from '@app/shared/utils';
import { JwtDecodedInfo } from '../types';
import { UserInfoService } from './user-info.service';

@Injectable({
  providedIn: 'root',
})
export class JwtService {

  private storageKey = `${environment.appSlug}.jwt`;

  constructor(
    private localStorageService: LocalStorageService,
    private userInfo: UserInfoService,
  ) {
    this.localStorageService.register(this.storageKey, this.parseJwt);
    this.userInfo.updateOrInit();
  }

  store(jwt: string): void {
    this.localStorageService.storeItem(this.storageKey, jwt);
  }

  clear(): void {
    this.localStorageService.clearItem(this.storageKey);
  }

  hasExpired(): boolean {

    const info = this.localStorageService.fetchItem<JwtDecodedInfo>(this.storageKey);

    if (info === null) {
      return true;
    }

    const expiration = asNumber(info.exp) * 1000;
    const now = Date.now();

    return now >= expiration;
  }

  parseJwt(jwt: string | null): JwtDecodedInfo | null {
    try {
      return (jwt !== null) ? jwt_decode(jwt) : null;
    } catch (error) {
      return null;
    }
  }
}
