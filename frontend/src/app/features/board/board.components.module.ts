import { NgModule } from '@angular/core';
import { MatCardModule } from '@angular/material/card';
import { MatIconModule } from '@angular/material/icon';
import { DragDropModule as CdkDragDropModule } from '@angular/cdk/drag-drop';

import { SkeletonModule } from '@app/shared/components/skeleton';
import { BackButtonComponentModule } from '@app/shared/components/back-button';

@NgModule({
  imports: [
    MatCardModule,
    MatIconModule,
    CdkDragDropModule,
    SkeletonModule,
    BackButtonComponentModule,
  ],
  exports: [
    MatCardModule,
    MatIconModule,
    CdkDragDropModule,
    SkeletonModule,
    BackButtonComponentModule,
  ],
})
export class BoardComponentsModule {}
