import { Injectable } from '@angular/core';
import { ActivatedRouteSnapshot, CanActivate, CanLoad, Route, RouterStateSnapshot, UrlSegment } from '@angular/router';

import { AuthenticationService } from '../services';

@Injectable()
export class ShouldNotBeLoggedGuard implements CanActivate, CanLoad {

  constructor(
    private authService: AuthenticationService,
  ) {}

  canActivate(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): boolean {
    return !this.authService.isSignedIn();
  }

  canLoad(route: Route, segments: UrlSegment[]): boolean {
    return !this.authService.isSignedIn();
  }
}
