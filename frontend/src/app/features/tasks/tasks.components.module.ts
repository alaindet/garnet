import { NgModule } from '@angular/core';

import { SkeletonComponentModule } from '@app/shared/components/skeleton';

@NgModule({
  imports: [
    SkeletonComponentModule,
  ],
  exports: [
    SkeletonComponentModule,
  ],
})
export class TasksComponentsModule {}
