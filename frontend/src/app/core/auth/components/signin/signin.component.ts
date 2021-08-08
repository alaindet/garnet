import { Component } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';

import { AuthenticationService } from '../../services';
import { SignInDto } from '../../types';

@Component({
  templateUrl: './signin.component.html',
  styleUrls: ['./signin.component.scss'],
})
export class SignInComponent {

  isLoading = false;

  signInForm = new FormGroup({
    email: new FormControl('', [Validators.required, Validators.email]),
    password: new FormControl('', [Validators.required]),
  });

  constructor(
    private authService: AuthenticationService,
  ) {}

  onSubmit(): void {

    if (this.signInForm.invalid) {
      return;
    }

    const dto: SignInDto = this.signInForm.value;

    this.authService.signIn(dto).subscribe({
      next: res => {
        console.log('SignInComponent.onSubmit next', res);
      },
      error: err => {
        console.log('SignInComponent.onSubmit error', err);
      },
    });

    // ...
  }
}