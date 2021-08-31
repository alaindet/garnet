import { NgModule } from '@angular/core';
import { MatCardModule } from '@angular/material/card';

import { SkeletonComponentModule } from '@app/shared/components/skeleton';

@NgModule({
  imports: [
    MatCardModule,
    SkeletonComponentModule,
  ],
  exports: [
    MatCardModule,
    SkeletonComponentModule,
  ],
})
export class BoardComponentsModule {}
