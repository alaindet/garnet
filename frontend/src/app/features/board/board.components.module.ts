import { NgModule } from '@angular/core';
import { MatCardModule } from '@angular/material/card';
import { MatIconModule } from '@angular/material/icon';
import { DragDropModule as CdkDragDropModule } from '@angular/cdk/drag-drop';

import { SkeletonComponentModule } from '@app/shared/components/skeleton';

@NgModule({
  imports: [
    MatCardModule,
    MatIconModule,
    CdkDragDropModule,
    SkeletonComponentModule,
  ],
  exports: [
    MatCardModule,
    MatIconModule,
    CdkDragDropModule,
    SkeletonComponentModule,
  ],
})
export class BoardComponentsModule {}
