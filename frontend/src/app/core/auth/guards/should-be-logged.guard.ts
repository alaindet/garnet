import { Injectable } from '@angular/core';
import { CanLoad, Route, Router, UrlSegment } from '@angular/router';

import { AuthenticationService } from '../services';

@Injectable()
export class ShouldBeLoggedGuard implements CanLoad {

  constructor(
    private router: Router,
    private authService: AuthenticationService,
  ) {}

  canLoad(route: Route, segments: UrlSegment[]): boolean {

    if (!this.authService.isSignedIn()) {
      this.router.navigate(['/auth/sign-in']);
      return false;
    }

    return true;
  }
}