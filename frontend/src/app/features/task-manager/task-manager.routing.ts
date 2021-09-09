import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

import { TaskManagerListComponent, TaskFormComponent } from './components';

const routes: Routes = [
  {
    path: ':courseid/tasks/create',
    component: TaskFormComponent,
  },
  {
    path: ':courseid/tasks/:taskid',
    component: TaskFormComponent,
  },
  {
    path: ':courseid',
    component: TaskManagerListComponent,
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class TaskManagerRoutingModule {}
