import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule } from '@angular/forms';

import { InviteRoutingModule } from './invite.routing';
import { InviteComponentsModule } from './invite.components.module';
import { InviteStudentComponent, AcceptInviteComponent, AcceptInviteBySigningInComponent, AcceptInviteByRegistrationComponent } from './components';
import { InviteService } from './services';

@NgModule({
  imports: [
    CommonModule,
    ReactiveFormsModule,
    InviteRoutingModule,
    InviteComponentsModule,
  ],
  declarations: [
    InviteStudentComponent,
    AcceptInviteComponent,
    AcceptInviteBySigningInComponent,
    AcceptInviteByRegistrationComponent,
  ],
  providers: [
    InviteService,
  ],
})
export class InviteModule {}
