import { Injectable } from '@angular/core';
import { ActivatedRouteSnapshot, CanActivate, RouterStateSnapshot, CanLoad, Route, UrlSegment, Router } from '@angular/router';
import { Observable } from 'rxjs';
import { tap } from 'rxjs/operators';

import { UiService } from '@app/core/main-layout/services';
import { AuthorizationService } from '../services';
import { UserRole } from '../types';

@Injectable()
export class ShouldHaveRoleGuard implements CanActivate, CanLoad {

  protected requiredRoles!: UserRole | UserRole[];

  constructor(
    private authorizationService: AuthorizationService,
    private ui: UiService,
    private router: Router,
  ) {}

  canActivate(
    route: ActivatedRouteSnapshot,
    state: RouterStateSnapshot,
  ): Observable<boolean> {
    return this.checkRequiredRoles(this.requiredRoles);
  }

  canLoad(route: Route, segments: UrlSegment[]): Observable<boolean> {
    return this.checkRequiredRoles(this.requiredRoles);
  }

  private checkRequiredRoles(
    requiredRoles: UserRole | UserRole[],
  ): Observable<boolean> {
    return this.authorizationService.hasRole(requiredRoles)
      .pipe(tap(hasRole => {
        if (!hasRole) {
          this.ui.setErrorToaster('You are not authorized');
          this.router.navigate(['/']);
        }
      }));
  }
}
