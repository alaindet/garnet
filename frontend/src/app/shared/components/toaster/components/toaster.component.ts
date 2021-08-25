import { ChangeDetectionStrategy, Component } from '@angular/core';

import { ToasterService } from '../services';

@Component({
  selector: 'app-toaster',
  templateUrl: './toaster.component.html',
  styleUrls: ['./toaster.component.scss'],
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export class ToasterComponent {

  constructor(
    public toaster: ToasterService,
  ) {}

  onDismiss(): void {
    this.toaster.clearToaster();
  }
}
