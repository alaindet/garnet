import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule } from '@angular/forms';

import { CoursesRoutingModule } from './courses.routing.module';
import { CoursesComponentsModule } from './courses.components.module';
import { CoursesListComponent, CourseFormComponent, ConfirmDeleteComponent } from './components';
import { CoursesService } from './services';

@NgModule({
  imports: [
    CommonModule,
    ReactiveFormsModule,
    CoursesRoutingModule,
    CoursesComponentsModule,
  ],
  declarations: [
    CoursesListComponent,
    CourseFormComponent,
    ConfirmDeleteComponent,
  ],
  providers: [
    CoursesService,
  ],
})
export class CoursesModule {}
