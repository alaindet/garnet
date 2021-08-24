import { NgModule } from '@angular/core';
import { MatButtonModule } from '@angular/material/button';
import { MatCardModule } from '@angular/material/card';
import { MatIconModule } from '@angular/material/icon';

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
    SkeletonComponentModule,
  ],
})
export class TaskManagerComponentsModule {}
