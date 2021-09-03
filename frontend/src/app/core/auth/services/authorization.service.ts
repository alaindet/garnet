import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { map } from 'rxjs/operators';

import { UserInfoService } from './user-info.service';
import { UserRole } from '../types';
import { JwtService } from './jwt.service';

@Injectable({
  providedIn: 'root',
})
export class AuthorizationService {

  constructor(
    private userInfo: UserInfoService,
    private jwtService: JwtService,
  ) {}

  hasRole(role: UserRole | UserRole[]): Observable<boolean> {
    return this.userInfo.roleId$.pipe(map(userRole => {

      if (userRole === null) {
        return false;
      }

      return (Array.isArray(role))
        ? role.includes(userRole)
        : role === userRole;

    }));
  }
}
