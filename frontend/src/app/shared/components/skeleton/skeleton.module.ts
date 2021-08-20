import { CommonModule } from '@angular/common';
import { NgModule } from '@angular/core';
import { SkeletonComponent } from './skeleton.component';

@NgModule({
  imports: [
    CommonModule,
  ],
  declarations: [
    SkeletonComponent,
  ],
  exports: [
    SkeletonComponent,
  ],
})
export class SkeletonComponentModule {}
