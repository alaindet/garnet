import { Component } from '@angular/core';
import { Location } from '@angular/common';
import { Router } from '@angular/router';

import { AuthenticationService } from '../../services';

@Component({
  templateUrl: './signout.component.html',
  styleUrls: ['./signout.component.scss'],
})
export class SignOutComponent {

  constructor(
    private location: Location,
    private authService: AuthenticationService,
    private router: Router,
  ) {}

  onBackClick(): void {
    this.location.back();
  }

  onSignOut(): void {
    this.authService.signOut();
    this.router.navigate(['/auth/sign-in']);
  }
}
