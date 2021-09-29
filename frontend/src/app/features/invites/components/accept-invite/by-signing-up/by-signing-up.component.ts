import { Component, Input, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { ToasterService } from '@app/shared/components/toaster';

@Component({
  selector: 'app-accept-invite-by-signing-up',
  templateUrl: './by-signing-up.component.html',
  styleUrls: ['./by-signing-up.component.scss'],
})
export class AcceptInviteBySigningUpComponent implements OnInit {

  @Input() inviteToken!: string;

  isLoading = false;
  signUpForm!: FormGroup;

  constructor(
    private toaster: ToasterService,
    private formBuilder: FormBuilder,
  ) {}

  ngOnInit(): void {
    this.initForm();
  }

  onSubmit(): void {

    if (this.signUpForm.invalid) {
      this.toaster.setError('Please provide all info before submitting');
      return;
    }

    /*
    export interface AcceptInviteBySigningUpRequest {
      email: string;
      password: string;
      firstName: string;
      lastName: string;
      token: string;
    }
    */

    console.log('onSubmit', this.signUpForm.value);
  }

  private initForm(): void {
    this.signUpForm = this.formBuilder.group({
      email: [null, [Validators.required, Validators.email]],
      password: [null, [Validators.required]],
      firstName: [null, [Validators.required, Validators.min(2)]],
      lastName: [null, [Validators.required, Validators.min(2)]],
    });
  }
}
