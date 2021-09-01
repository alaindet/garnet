import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

import { ShouldHaveStudentRoleGuard, ShouldHaveTeacherRoleGuard } from '@app/core/auth';
import { CoursesListComponent } from './components/list/list.component';
import { CourseFormComponent } from './components/form/form.component';
import { CoursesAction } from './actions';

const routes: Routes = [
  {
    path: '',
    component: CoursesListComponent,
    data: { fab: CoursesAction.ShowCreateCourseForm },
  },
  {
    path: 'create',
    component: CourseFormComponent,
    data: { action: CoursesAction.ShowCreateCourseForm },
  },
  {
    path: ':courseid/task-manager',
    canLoad: [ShouldHaveTeacherRoleGuard],
    loadChildren: () => import('../task-manager/task-manager.module')
      .then(m => m.TaskManagerModule),
  },
  {
    path: ':courseid/board',
    canLoad: [ShouldHaveStudentRoleGuard],
    loadChildren: () => import('../board/board.module')
      .then(m => m.BoardModule),
  },
  {
    path: ':courseid',
    component: CourseFormComponent,
    data: { action: CoursesAction.ShowEditCourseForm },
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class CoursesRoutingModule {}
