import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule } from '@angular/forms';

import { TaskManagerRoutingModule } from './task-manager.routing';
import { TaskManagerComponentsModule } from './task-manager.components.module';
import { TaskManagerListComponent } from './components';

@NgModule({
  imports: [
    CommonModule,
    ReactiveFormsModule,
    TaskManagerRoutingModule,
    TaskManagerComponentsModule,
  ],
  declarations: [
    TaskManagerListComponent,
  ],
  providers: [
    // ...
  ],
})
export class CoursesModule {}
