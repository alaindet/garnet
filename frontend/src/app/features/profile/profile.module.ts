import { NgModule } from '@angular/core';

import { ProfileComponent } from './components';
import { ProfileRoutingModule } from './profile.routing';
import { ProfileService } from './services';

@NgModule({
  imports: [
    ProfileRoutingModule,
  ],
  declarations: [
    ProfileComponent,
  ],
  providers: [
    ProfileService,
  ],
})
export class ProfileModule {}
