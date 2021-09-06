import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

import { CourseStudentsComponent } from './components';

const routes: Routes = [
  {
    path: '',
    component: CourseStudentsComponent,
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class CourseStudentsRoutingModule {}
