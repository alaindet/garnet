import { Injectable } from '@angular/core';
import { ActivatedRouteSnapshot, CanActivate, RouterStateSnapshot, CanLoad, Route, UrlSegment } from '@angular/router';
import { Observable } from 'rxjs';

import { AuthorizationService } from '../services';
import { UserRole } from '../types';

@Injectable()
export class ShouldHaveTeacherRoleGuard implements CanActivate, CanLoad {

  constructor(
    private authorizationService: AuthorizationService,
  ) {}

  canActivate(
    route: ActivatedRouteSnapshot,
    state: RouterStateSnapshot,
  ): Observable<boolean> {
    return this.checkTeacherRole();
  }

  canLoad(route: Route, segments: UrlSegment[]): Observable<boolean> {
    return this.checkTeacherRole();
  }

  private checkTeacherRole(): Observable<boolean> {
    return this.authorizationService.hasRole([
      UserRole.Admin,
      UserRole.Teacher,
    ]);
  }
}
