import { Component, Input } from '@angular/core';

@Component({
  selector: 'app-accept-invite-by-registration',
  templateUrl: './by-registration.component.html',
  styleUrls: ['./by-registration.component.scss'],
})
export class AcceptInviteByRegistrationComponent {

  @Input() inviteToken!: string;
}
