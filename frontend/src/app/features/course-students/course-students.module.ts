import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule } from '@angular/forms';

import { CourseStudentsRoutingModule } from './course-students.routing';
import { CourseStudentsComponentsModule } from './course-students.components.module';
import { CourseStudentsComponent } from './components';

@NgModule({
  imports: [
    CommonModule,
    ReactiveFormsModule,
    CourseStudentsRoutingModule,
    CourseStudentsComponentsModule,
  ],
  declarations: [
    CourseStudentsComponent,
  ],
  providers: [
    // ...
  ],
})
export class CourseStudentsModule {}
