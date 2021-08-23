import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

import { TaskManagerListComponent } from './components';
import { TaskManagerAction } from './actions';

const routes: Routes = [
  {
    path: '',
    component: TaskManagerListComponent,
    data: { fab: TaskManagerAction.ShowCreateTaskForm },
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class TaskManagerRoutingModule {}
