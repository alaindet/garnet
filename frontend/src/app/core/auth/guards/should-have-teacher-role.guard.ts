import { Injectable } from '@angular/core';
import { ActivatedRouteSnapshot, CanActivate, RouterStateSnapshot, CanLoad, Route, UrlSegment } from '@angular/router';
import { ToasterService } from '@app/shared/components/toaster';

import { environment } from '@environment/environment';
import { AuthenticationService } from '../services';
import { UserRole } from '../types';

@Injectable()
export class ShouldHaveTeacherRoleGuard implements CanActivate, CanLoad {

  constructor(
    private authService: AuthenticationService,
    private toaster: ToasterService,
  ) { }

  canActivate(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): boolean {
    return this.checkTeacherRole();
  }

  canLoad(route: Route, segments: UrlSegment[]): boolean {
    return this.checkTeacherRole();
  }

  private checkTeacherRole(): boolean {

    const decodedToken = this.authService.getDecodedToken();

    if (decodedToken === null) {
      return false;
    }

    const roleClaim = `${environment.appSlug}.role`;
    const role = decodedToken[roleClaim];

    if (![UserRole.Teacher, UserRole.Admin].includes(role)) {
      this.toaster.setError('You must have the "teacher" role to access');
      return false;
    }

    return true;
  }
}
