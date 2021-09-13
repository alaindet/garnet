import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

import { ShouldHaveTeacherRoleGuard } from '@app/core/auth';
import { InviteStudentComponent } from './components';

const routes: Routes = [
  {
    path: 'student',
    canActivate: [ShouldHaveTeacherRoleGuard],
    component: InviteStudentComponent,
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class InviteRoutingModule {}
