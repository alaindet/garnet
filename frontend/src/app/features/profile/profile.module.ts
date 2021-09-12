import { CommonModule } from '@angular/common';
import { NgModule } from '@angular/core';

import { ProfileRoutingModule } from './profile.routing';
import { ProfileComponentsModule } from './profile.components.module';
import { ProfileComponent } from './components';
import { ProfileService } from './services';

@NgModule({
  imports: [
    CommonModule,
    ProfileRoutingModule,
    ProfileComponentsModule,
  ],
  declarations: [
    ProfileComponent,
  ],
  providers: [
    ProfileService,
  ],
})
export class ProfileModule {}
