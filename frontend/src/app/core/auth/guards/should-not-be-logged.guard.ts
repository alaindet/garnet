import { Injectable } from '@angular/core';
import { ActivatedRouteSnapshot, CanActivate, RouterStateSnapshot } from '@angular/router';

import { AuthenticationService } from '../services';

@Injectable()
export class ShouldNotBeLoggedGuard implements CanActivate {

  constructor(
    private authService: AuthenticationService,
  ) {}

  canActivate(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): boolean {
    return !this.authService.isSignedIn();
  }
}