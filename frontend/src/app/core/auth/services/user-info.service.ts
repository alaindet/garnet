import { Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs';

import { environment } from '@environment/environment';
import { JwtDecodedInfo, UserRole } from '../types';

@Injectable({
  providedIn: 'root',
})
export class UserInfoService {

  private _userId$ = new BehaviorSubject<string | number | null>(null);
  private _roleId$ = new BehaviorSubject<UserRole | null>(null);

  userId$ = this._userId$.asObservable();
  roleId$ = this._roleId$.asObservable();

  update(info: JwtDecodedInfo): void {
    const userRoleKey = `${environment.appSlug}.role`;
    this._userId$.next(info.sub);
    this._roleId$.next(info[userRoleKey]);
  }

  reset(): void {
    this._userId$.next(null);
    this._roleId$.next(null);
  }

  set userId(id: string | number | null) {
    this._userId$.next(id);
  }

  set roleId(role: UserRole | null) {
    this._roleId$.next(role);
  }
}
