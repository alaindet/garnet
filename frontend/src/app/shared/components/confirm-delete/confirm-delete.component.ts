import { ChangeDetectionStrategy, Component, Inject } from '@angular/core';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material/dialog';

import { ConfirmDeleteDialogConfig } from '@app/shared/types';

@Component({
  templateUrl: './confirm-delete.component.html',
  styleUrls: ['./confirm-delete.component.scss'],
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export class ConfirmDeleteComponent {

  constructor(
    @Inject(MAT_DIALOG_DATA) public data: ConfirmDeleteDialogConfig,
    private matDialogRef: MatDialogRef<ConfirmDeleteComponent, boolean>,
  ) {}

  onConfirm(): void {
    this.matDialogRef.close(true);
  }
}
