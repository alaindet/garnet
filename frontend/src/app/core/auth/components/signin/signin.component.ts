import { Component } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';

import { SignInService } from '../../services';
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
    private signInService: SignInService,
  ) {}

  onSubmit(): void {

    console.log('ciao');

    if (this.signInForm.invalid) {
      return;
    }

    const dto: SignInDto = this.signInForm.value;

    this.signInService.signIn(dto).subscribe(response => {
      console.log('response', response);
    });

    // ...
  }
}