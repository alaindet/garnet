import { Component } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { finalize } from 'rxjs/operators';
import { MessageService as PrimeMessageService } from 'primeng/api';

import { AuthenticationService } from '../../services';
import { SignInDto } from '../../types';

@Component({
  templateUrl: './signin.component.html',
  styleUrls: ['./signin.component.scss'],
  providers: [PrimeMessageService],
})
export class SignInComponent {

  isLoading = false;

  signInForm = new FormGroup({
    email: new FormControl('', [Validators.required, Validators.email]),
    password: new FormControl('', [Validators.required]),
  });

  constructor(
    private authService: AuthenticationService,
    private router: Router,
    private messageService: PrimeMessageService,
  ) {}

  onSubmit(): void {

    if (this.signInForm.invalid || this.isLoading) {
      return;
    }

    const dto: SignInDto = this.signInForm.value;

    this.isLoading = true;

    this.authService.signIn(dto)
      .pipe(finalize(() => this.isLoading = false))
      .subscribe({
        next: () => this.router.navigate(['/courses']),
        error: err => {
          console.error(err);
          this.messageService.add({
            severity: 'error',
            summary: 'Error',
            detail: 'Wrong email and/or password',
          });
        },
      });

    // ...
  }
}