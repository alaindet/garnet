import { Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs';
import { UserRole } from '../types';

@Injectable({
  providedIn: 'root',
})
export class UserInfoService {

  private _userId$ = new BehaviorSubject<string | number | null>(null);
  private _userRole$ = new BehaviorSubject<UserRole | null>(null);

  userId$ = this._userId$.asObservable();
  userRole$ = this._userRole$.asObservable();
}
