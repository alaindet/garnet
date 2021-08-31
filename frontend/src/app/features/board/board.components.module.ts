import { NgModule } from '@angular/core';
import { MatCardModule } from '@angular/material/card';
import { DragDropModule as CdkDragDropModule } from '@angular/cdk/drag-drop';

import { SkeletonComponentModule } from '@app/shared/components/skeleton';

@NgModule({
  imports: [
    MatCardModule,
    CdkDragDropModule,
    SkeletonComponentModule,
  ],
  exports: [
    MatCardModule,
    CdkDragDropModule,
    SkeletonComponentModule,
  ],
})
export class BoardComponentsModule {}
