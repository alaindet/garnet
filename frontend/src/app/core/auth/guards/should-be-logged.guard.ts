import { Injectable } from '@angular/core';
import { Router, ActivatedRouteSnapshot, CanActivate, RouterStateSnapshot, CanLoad, Route, UrlSegment } from '@angular/router';

import { AuthenticationService } from '../services';

@Injectable()
export class ShouldBeLoggedGuard implements CanActivate, CanLoad {

  constructor(
    private router: Router,
    private authService: AuthenticationService,
  ) {}

  canActivate(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): boolean {
    return this.checkAuthentication();
  }

  canLoad(route: Route, segments: UrlSegment[]): boolean {
    return this.checkAuthentication();
  }

  private checkAuthentication(): boolean {

    if (!this.authService.isSignedIn()) {
      this.router.navigate(['/auth/sign-in']);
      return false;
    }

    return true;
  }
}
