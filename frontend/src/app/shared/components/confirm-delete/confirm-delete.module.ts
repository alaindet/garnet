import { NgModule } from '@angular/core';
import { MatButtonModule } from '@angular/material/button';
import { MatDialogModule } from '@angular/material/dialog';
import { MatIconModule } from '@angular/material/icon';

import { ConfirmDeleteComponent } from './confirm-delete.component';

@NgModule({
  imports: [
    MatButtonModule,
    MatIconModule,
    MatDialogModule,
  ],
  declarations: [ConfirmDeleteComponent],
  exports: [ConfirmDeleteComponent],
})
export class ConfirmDeleteComponentModule {}
