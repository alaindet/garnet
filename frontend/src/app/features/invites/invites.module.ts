import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule } from '@angular/forms';

import { InvitesRoutingModule } from './invites.routing';
import { InvitesComponentsModule } from './invites.components.module';
import { InviteStudentComponent, AcceptInviteComponent, AcceptInviteBySigningInComponent, AcceptInviteBySigningUpComponent } from './components';
import { InviteService } from './services';

@NgModule({
  imports: [
    CommonModule,
    ReactiveFormsModule,
    InvitesRoutingModule,
    InvitesComponentsModule,
  ],
  declarations: [
    InviteStudentComponent,
    AcceptInviteComponent,
    AcceptInviteBySigningInComponent,
    AcceptInviteBySigningUpComponent,
  ],
  providers: [
    InviteService,
  ],
})
export class InvitesModule {}
