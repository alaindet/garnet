import { ChangeDetectionStrategy, Component, Input } from '@angular/core';
import { Location } from '@angular/common';
import { Router } from '@angular/router';

@Component({
  selector: 'app-back-button',
  templateUrl: './back-button.component.html',
  styleUrls: ['./back-button.component.scss'],
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export class BackButtonComponent {

  @Input() to?: string | string[];

  constructor(
    private location: Location,
    private router: Router,
  ) {}

  onBackClick(): void {

    if (!this.to) {
      this.location.back();
      return;
    }

    const urlSegments = Array.isArray(this.to) ? this.to : [this.to];
    this.router.navigate(urlSegments);
  }
}
