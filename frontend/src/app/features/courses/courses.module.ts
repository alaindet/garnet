import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule } from '@angular/forms';

import { CoursesRoutingModule } from './courses.routing';
import { CoursesComponentsModule } from './courses.components.module';
import { CoursesListComponent, CourseFormComponent, CoursesListItemActionsComponent } from './components';
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
    CoursesListItemActionsComponent,
  ],
  providers: [
    CoursesService,
  ],
})
export class CoursesModule {}
