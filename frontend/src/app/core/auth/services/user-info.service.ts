import { Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs';

import { environment } from '@environment/environment';
import { JwtDecodedInfo, UserRole } from '../types';

@Injectable({
  providedIn: 'root',
})
export class UserInfoService {

  private _id$ = new BehaviorSubject<string | number | null>(null);
  private _role$ = new BehaviorSubject<UserRole | null>(null);

  id$ = this._id$.asObservable();
  role$ = this._role$.asObservable();

  updateOrInit(info: JwtDecodedInfo): void {
    this._id$.next(info.sub);
    const userRoleKey = `${environment.appSlug}.role`;
    this._role$.next(info[userRoleKey]);
  }

  set id(id: string | number | null) {
    this._id$.next(id);
  }

  set role(role: UserRole | null) {
    this._role$.next(role);
  }
}
