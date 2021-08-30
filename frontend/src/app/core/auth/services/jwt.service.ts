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
    this.updateUserInfo();
    this.localStorageService.register(this.storageKey, this.parseJwt);
  }

  fetch(): JwtDecodedInfo | null {
    return this.localStorageService.fetchItem(this.storageKey);
  }

  store(jwt: string): void {
    const decodedJwt = this.parseJwt(jwt);
    this.localStorageService.storeItem(this.storageKey, jwt);
    this.updateUserInfo(decodedJwt);
  }

  clear(): void {
    this.localStorageService.clearItem(this.storageKey);
    this.resetUserInfo();
  }

  hasExpired(): boolean {

    const key = this.storageKey;
    const info = this.localStorageService.fetchItem<JwtDecodedInfo>(key);

    if (info === null) {
      return true;
    }

    const expiration = asNumber(info.exp) * 1000;
    const now = Date.now();

    return now >= expiration;
  }

  private parseJwt(jwt: string | null): JwtDecodedInfo | null {
    try {
      return (jwt !== null) ? jwt_decode(jwt) : null;
    } catch (error) {
      return null;
    }
  }

  private updateUserInfo(decodedJwt: JwtDecodedInfo | null = null): void {
    decodedJwt = decodedJwt ?? this.fetch();
    if (decodedJwt) {
      this.userInfo.update(decodedJwt);
    }
  }

  private resetUserInfo(): void {
    this.userInfo.reset();
  }
}
