import { NgModule } from '@angular/core';
import { MatButtonModule } from '@angular/material/button';
import { MatIconModule } from '@angular/material/icon';

import { BackButtonComponent } from './back-button.component';

@NgModule({
  imports: [
    MatButtonModule,
    MatIconModule,
  ],
  declarations: [BackButtonComponent],
  exports: [BackButtonComponent],
})
export class BackButtonComponentModule {}
