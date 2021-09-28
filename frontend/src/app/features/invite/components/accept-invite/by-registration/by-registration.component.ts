import { Component, Input, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { ToasterService } from '@app/shared/components/toaster';

@Component({
  selector: 'app-accept-invite-by-registration',
  templateUrl: './by-registration.component.html',
  styleUrls: ['./by-registration.component.scss'],
})
export class AcceptInviteByRegistrationComponent implements OnInit {

  @Input() inviteToken!: string;

  isLoading = false;
  registrationForm!: FormGroup;

  constructor(
    private toaster: ToasterService,
    private formBuilder: FormBuilder,
  ) {}

  ngOnInit(): void {
    this.initForm();
  }

  onSubmit(): void {

    if (this.registrationForm.invalid) {
      // TODO: Feedback
      return;
    }

    console.log('onSubmit', this.registrationForm.value);
  }

  private initForm(): void {
    this.registrationForm = this.formBuilder.group({
      email: [null, [Validators.required, Validators.email]],
      password: [null, [Validators.required]],
      firstName: [null, [Validators.required, Validators.min(2)]],
      lastName: [null, [Validators.required, Validators.min(2)]],
    });
  }
}
