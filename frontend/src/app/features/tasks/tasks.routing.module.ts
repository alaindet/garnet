import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

import { TasksListComponent } from './components/list/list.component';
import { TasksAction } from './actions';

const routes: Routes = [
  {
    path: '',
    component: TasksListComponent,
    data: { fab: TasksAction.ShowCreateTaskForm },
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class TasksRoutingModule {}
