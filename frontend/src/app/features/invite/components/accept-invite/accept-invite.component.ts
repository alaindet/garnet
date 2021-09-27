import { Component } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { Subscription } from 'rxjs';

import { UiService } from '@app/core/main-layout/services';

@Component({
  templateUrl: './accept-invite.component.html',
  styleUrls: ['./accept-invite.component.scss'],
})
export class AcceptInviteComponent {

  inviteToken!: string;
  tabIndex = 0;
  tabsLoaded = [false, false];

  private subs: { [sub: string]: Subscription } = {};

  constructor(
    public ui: UiService,
    private route: ActivatedRoute,
  ) {}

  ngOnInit(): void {
    this.validateToken();
  }

  onTabChange(tabIndex: number): void {
    this.tabIndex = tabIndex;
    this.tabsLoaded[tabIndex] = true;
  }

  private validateToken(): void {
    this.ui.loading = true;
    const token =
    // ...
    // Start loading state
    // Check if token in query params exists
    // Check if token is valid via API
    // Stop loading state
    // Select first tab
  }
}
