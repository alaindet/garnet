import { Injectable } from '@angular/core';

import { environment } from '@environment/environment';
import { asNumber } from '@app/shared/utils';
import { JwtService } from './jwt.service';
import { UserRole } from '../types';

@Injectable({
  providedIn: 'root',
})
export class AuthorizationService {

  constructor(
    private jwtService: JwtService,
  ) {}

  hasRole(role: UserRole | UserRole[]): boolean {

    const currentRole = this.getUserRole();

    if (currentRole === null) {
      return false;
    }

    if (Array.isArray(role)) {
      return role.includes(this.getUserRole());
    }

    return role === this.getUserRole();
  }

  getUserRole(): number | null {
    const userInfo = this.jwtService.decode();

    if (userInfo === null) {
      return null;
    }

    const roleClaim = `${environment.appSlug}.role`;
    return asNumber(userInfo[roleClaim]);
  }
}
