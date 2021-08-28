import { Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs';

import { UserRole } from '../types';
import { JwtService } from './jwt.service';

@Injectable({
  providedIn: 'root',
})
export class UserInfoService {

  private _id$ = new BehaviorSubject<string | number | null>(null);
  private _role$ = new BehaviorSubject<UserRole | null>(null);

  id$ = this._id$.asObservable();
  role$ = this._role$.asObservable();

  set id(id: string | number | null) {
    this._id$.next(id);
  }

  set role(role: UserRole | null) {
    this._role$.next(role);
  }
}
