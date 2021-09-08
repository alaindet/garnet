import { NgModule } from '@angular/core';
import { MatIconModule } from '@angular/material/icon';
import { MatTabsModule } from '@angular/material/tabs';

import { BackButtonComponentModule } from '@app/shared/components/back-button';
@NgModule({
  imports: [
    BackButtonComponentModule,
    MatTabsModule,
    MatIconModule,
  ],
  exports: [
    BackButtonComponentModule,
    MatTabsModule,
    MatIconModule,
  ],
})
export class ProgressComponentsModule {}
