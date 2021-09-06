import { NgModule } from '@angular/core';
import { MatIconModule } from '@angular/material/icon';
import { MatButtonModule } from '@angular/material/button';
import { MatCardModule } from '@angular/material/card';
import { MatMenuModule } from '@angular/material/menu';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatInputModule } from '@angular/material/input';
import { MatDialogModule } from '@angular/material/dialog';

import { ConfirmDeleteComponentModule } from '@app/shared/components/confirm-delete';
import { BackButtonComponentModule } from '@app/shared/components/back-button';
import { SkeletonModule } from '@app/shared/components/skeleton';

@NgModule({
  imports: [
    MatIconModule,
    MatButtonModule,
    MatCardModule,
    MatMenuModule,
    MatFormFieldModule,
    MatInputModule,
    MatDialogModule,
    BackButtonComponentModule,
    SkeletonModule,
    ConfirmDeleteComponentModule,
  ],
  exports: [
    MatIconModule,
    MatButtonModule,
    MatCardModule,
    MatMenuModule,
    MatFormFieldModule,
    MatInputModule,
    MatDialogModule,
    BackButtonComponentModule,
    SkeletonModule,
    ConfirmDeleteComponentModule,
  ],
})
export class CoursesComponentsModule {}
