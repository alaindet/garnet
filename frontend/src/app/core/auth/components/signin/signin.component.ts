import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
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
  signInForm!: FormGroup;

  constructor(
    private authService: AuthenticationService,
    private router: Router,
    private titleService: Title,
    private toaster: ToasterService,
    private formBuilder: FormBuilder,
  ) {}

  ngOnInit(): void {
    this.titleService.setTitle(`${this.title} || Sign In`);
    this.initForm();
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

  private initForm(): void {
    this.signInForm = this.formBuilder.group({
      email: [null, [Validators.required, Validators.email]],
      password: [null, Validators.required],
    });
  }
}
