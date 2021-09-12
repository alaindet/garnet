import { Component, OnInit } from '@angular/core';
import { finalize } from 'rxjs/operators';

import { UiService } from '@app/core/main-layout/services';
import { ProfileService } from '../../services';
import { UserProfile } from '../../types';

@Component({
  templateUrl: './profile.component.html',
  styleUrls: ['./profile.component.scss'],
})
export class ProfileComponent implements OnInit {

  profile: UserProfile | null = null;

  constructor(
    private ui: UiService,
    private profileService: ProfileService,
  ) {}

  ngOnInit(): void {
    this.fetchProfile();
  }

  private fetchProfile(): void {
    this.ui.loading = true;
    this.profileService.getProfile()
      .pipe(finalize(() => this.ui.loading = false))
      .subscribe({
        error: err => this.ui.setErrorToaster(err.error.error.message),
        next: profile => {
          this.profile = profile;
          this.ui.title = 'Profile';
          this.ui.breadcrumbs = [
            { label: 'Profile', url: '/profile' },
          ];
        }
      });
  }
}
