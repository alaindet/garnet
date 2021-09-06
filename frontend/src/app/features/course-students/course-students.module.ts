import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule } from '@angular/forms';

import { CourseStudentsRoutingModule } from './course-students.routing';
import { CourseStudentsComponentsModule } from './course-students.components.module';

@NgModule({
  imports: [
    CommonModule,
    ReactiveFormsModule,
    CourseStudentsRoutingModule,
    CourseStudentsComponentsModule,
  ],
  declarations: [
    // ...
  ],
  providers: [
    // ...
  ],
})
export class CourseProgressModule {}
