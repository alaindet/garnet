import { NgModule } from '@angular/core';
import { MatIconModule } from '@angular/material/icon';
import { MatTabsModule } from '@angular/material/tabs';

import { BackButtonComponentModule } from '@app/shared/components/back-button';
import { TruncatePipeModule } from '@app/shared/pipes/truncate';
@NgModule({
  imports: [
    BackButtonComponentModule,
    MatTabsModule,
    MatIconModule,
    TruncatePipeModule,
  ],
  exports: [
    BackButtonComponentModule,
    MatTabsModule,
    MatIconModule,
    TruncatePipeModule,
  ],
})
export class ProgressComponentsModule {}
