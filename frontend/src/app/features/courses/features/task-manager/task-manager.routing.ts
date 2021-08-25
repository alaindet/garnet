import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

import { TaskManagerAction } from './actions';
import { TaskManagerListComponent, TaskFormComponent } from './components';

const routes: Routes = [
  {
    path: '',
    component: TaskManagerListComponent,
    data: { fab: TaskManagerAction.ShowCreateTaskForm },
  },
  {
    path: 'create',
    component: TaskFormComponent,
  },
  {
    path: ':taskid',
    component: TaskFormComponent,
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class TaskManagerRoutingModule {}
