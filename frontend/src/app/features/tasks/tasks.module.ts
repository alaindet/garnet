import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule } from '@angular/forms';

import { TasksRoutingModule } from './tasks.routing.module';
import { TasksComponentsModule } from './tasks.components.module';
import { TasksListComponent } from './components/list/list.component';

@NgModule({
  imports: [
    CommonModule,
    ReactiveFormsModule,
    TasksRoutingModule,
    TasksComponentsModule,
  ],
  declarations: [
    TasksListComponent,
  ],
  providers: [
    // ...
  ],
})
export class TasksModule {}
