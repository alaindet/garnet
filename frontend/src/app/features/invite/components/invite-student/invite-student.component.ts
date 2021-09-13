import { Component, OnDestroy, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { Subscription } from 'rxjs';
import { finalize } from 'rxjs/operators';

import { UiService } from '@app/core/main-layout/services';
import { InviteService } from '../../services';
import { ToasterService } from '@app/shared/components/toaster';
import { Router } from '@angular/router';

@Component({
  templateUrl: './invite-student.component.html',
  styleUrls: ['./invite-student.component.scss'],
})
export class InviteStudentComponent implements OnInit, OnDestroy {

  isLoading = false;

  inviteForm = new FormGroup({
    email: new FormControl(null, [Validators.required, Validators.email]),
    course: new FormControl(null, [Validators.required]),
  });

  private subs: { [sub: string]: Subscription } = {};

  constructor(
    private ui: UiService,
    private inviteService: InviteService,
    private toaster: ToasterService,
    private router: Router,
  ) {}

  ngOnInit(): void {
    this.ui.title = 'Invite Student';
    this.ui.breadcrumbs = [
      { label: 'Invite Student', url: '/invite/student' },
    ];
    this.subs.loading = this.ui.loading$
      .subscribe(isLoading => this.isLoading = isLoading);
  }

  ngOnDestroy(): void {
    for (const sub of Object.values(this.subs)) {
      sub.unsubscribe();
    }
  }

  onSubmit(): void {

    if (this.inviteForm.invalid || this.isLoading) {
      return;
    }

    const dto = null;

    this.ui.loading = true;

    // this.authService.signIn(dto)
    //   .pipe(finalize(() => this.ui.loading = false))
    //   .subscribe({
    //     next: () => this.router.navigate(['/courses']),
    //     error: err => this.toaster.setError('Wrong email and/or password'),
    //   });
  }
}
