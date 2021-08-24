import { NgModule } from '@angular/core';
import { MatButtonModule } from '@angular/material/button';
import { MatCardModule } from '@angular/material/card';
import { MatIconModule } from '@angular/material/icon';

import { BackButtonComponentModule } from '@app/shared/components/back-button';
import { SkeletonComponentModule } from '@app/shared/components/skeleton';

@NgModule({
  imports: [
    MatCardModule,
    MatButtonModule,
    MatIconModule,
    SkeletonComponentModule,
  ],
  exports: [
    MatCardModule,
    MatButtonModule,
    MatIconModule,
    BackButtonComponentModule,
    SkeletonComponentModule,
  ],
})
export class TaskManagerComponentsModule {}
