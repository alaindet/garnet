import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule } from '@angular/forms';

import { TaskManagerRoutingModule } from './task-manager.routing';
import { TaskManagerComponentsModule } from './task-manager.components.module';
import { TaskManagerListComponent, TaskFormComponent } from './components';
import { TaskManagerService } from './services';

@NgModule({
  imports: [
    CommonModule,
    ReactiveFormsModule,
    TaskManagerRoutingModule,
    TaskManagerComponentsModule,
  ],
  declarations: [
    TaskManagerListComponent,
    TaskFormComponent,
  ],
  providers: [
    TaskManagerService,
  ],
})
export class TaskManagerModule {}
