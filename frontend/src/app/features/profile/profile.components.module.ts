import { NgModule } from '@angular/core';
import { MatButtonModule } from '@angular/material/button';
import { MatCardModule } from '@angular/material/card';
import { MatIconModule } from '@angular/material/icon';
import { MatListModule } from '@angular/material/list';

import { SkeletonModule } from '@app/shared/components/skeleton';

@NgModule({
  imports: [
    MatCardModule,
    MatListModule,
    MatIconModule,
    MatButtonModule,
    SkeletonModule,
  ],
  exports: [
    MatCardModule,
    MatListModule,
    MatIconModule,
    MatButtonModule,
    SkeletonModule,
  ],
})
export class ProfileComponentsModule {}
