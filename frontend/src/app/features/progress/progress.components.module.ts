import { NgModule } from '@angular/core';
import { MatCardModule } from '@angular/material/card';
import { MatIconModule } from '@angular/material/icon';
import { MatTabsModule } from '@angular/material/tabs';

import { BackButtonComponentModule } from '@app/shared/components/back-button';
import { TruncatePipeModule } from '@app/shared/pipes/truncate';
@NgModule({
  imports: [
    MatTabsModule,
    MatIconModule,
    BackButtonComponentModule,
    TruncatePipeModule,
  ],
  exports: [
    MatTabsModule,
    MatIconModule,
    BackButtonComponentModule,
    TruncatePipeModule,
  ],
})
export class ProgressComponentsModule {}
