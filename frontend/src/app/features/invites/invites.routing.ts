import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

import { ShouldHaveTeacherRoleGuard } from '@app/core/auth';
import { InviteStudentComponent, AcceptInviteComponent } from './components';

const routes: Routes = [
  {
    path: 'student',
    canActivate: [ShouldHaveTeacherRoleGuard],
    component: InviteStudentComponent,
  },
  {
    path: 'accept',
    // canActivate: [], // Public
    component: AcceptInviteComponent,
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class InvitesRoutingModule {}
