import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { finalize, tap } from 'rxjs/operators';
import { Title } from '@angular/platform-browser';

import { environment } from '@environment/environment';
import { ToasterService } from '@app/shared/components/toaster';
import { AuthenticationService } from '../../services';
import { SignInDto } from '../../types';

@Component({
  templateUrl: './signin.component.html',
  styleUrls: ['./signin.component.scss'],
})
export class SignInComponent implements OnInit {

  isLoading = false;
  title = environment.appName;

  signInForm = new FormGroup({
    email: new FormControl('', [Validators.required, Validators.email]),
    password: new FormControl('', [Validators.required]),
  });

  constructor(
    private authService: AuthenticationService,
    private router: Router,
    private titleService: Title,
    private toaster: ToasterService,
  ) {}

  ngOnInit(): void {
    this.titleService.setTitle(`${this.title} || Sign In`);
  }

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
        error: err => this.toaster.setError('Wrong email and/or password'),
      });
  }
}
