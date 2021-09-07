import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule } from '@angular/forms';

import { ProgressRoutingModule } from './progress.routing';
import { ProgressComponentsModule } from './progress.components.module';
import { ProgressComponent } from './components';

@NgModule({
  imports: [
    CommonModule,
    ReactiveFormsModule,
    ProgressRoutingModule,
    ProgressComponentsModule,
  ],
  declarations: [
    ProgressComponent,
  ],
  providers: [
    // ...
  ],
})
export class ProgressModule {}
