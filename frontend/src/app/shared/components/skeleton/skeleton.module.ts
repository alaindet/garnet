import { CommonModule } from '@angular/common';
import { NgModule } from '@angular/core';
import { SkeletonComponent } from './skeleton.component';
import { SkeletonDotsComponent } from './skeleton-dots/skeleton-dots.component'

@NgModule({
  imports: [
    CommonModule,
  ],
  declarations: [
    SkeletonComponent,
    SkeletonDotsComponent,
  ],
  exports: [
    SkeletonComponent,
    SkeletonDotsComponent,
  ],
})
export class SkeletonModule {}
