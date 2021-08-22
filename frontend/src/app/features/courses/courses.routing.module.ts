import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

import { CoursesListComponent } from './components/list/list.component';
import { CreateCourseComponent } from './components/create/create.component';
import { CoursesAction } from './actions';

const routes: Routes = [
  {
    path: '',
    component: CoursesListComponent,
    data: { fab: CoursesAction.ShowCreateForm },
  },
  {
    path: 'create',
    component: CreateCourseComponent,
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class CoursesRoutingModule {}
