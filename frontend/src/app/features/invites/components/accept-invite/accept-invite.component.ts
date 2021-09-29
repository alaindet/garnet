import { ChangeDetectorRef, Component } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';

import { UiService } from '@app/core/main-layout/services';
import { finalize } from 'rxjs/operators';
import { InviteService } from '../../services';

@Component({
  templateUrl: './accept-invite.component.html',
  styleUrls: ['./accept-invite.component.scss'],
})
export class AcceptInviteComponent {

  inviteToken!: string;
  isTokenValid = false;
  isLoading = true;
  tabIndex = 0;
  tabsLoaded = [true, false];

  constructor(
    public ui: UiService,
    private route: ActivatedRoute,
    private router: Router,
    private inviteService: InviteService,
    private cdr: ChangeDetectorRef,
  ) {}

  ngOnInit(): void {
    this.validateToken();
    this.ui.title = 'Accept invite';
  }

  onTabChange(tabIndex: number): void {
    this.tabIndex = tabIndex;
    this.tabsLoaded[tabIndex] = true;
  }

  private validateToken(): void {
    this.isLoading = true;
    this.inviteToken = this.route.snapshot.queryParams['token'];

    if (!this.inviteToken) {
      this.isLoading = false;
      this.handleInvalidToken();
      return;
    }

    this.inviteService.checkInviteToken(this.inviteToken)
      .pipe(finalize(() => this.isLoading = false))
      .subscribe({
        error: () => this.handleInvalidToken(),
        next: () => {
          this.ui.setSuccessToaster('Invite token is valid');
          this.isTokenValid = true;
        },
      });
  }

  private handleInvalidToken(message: string | null = null): void {
    this.ui.setErrorToaster(message ?? 'Invalid token');
    this.router.navigate(['/']);
  }
}
