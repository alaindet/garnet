import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

import { ShouldHaveStudentRoleGuard, ShouldHaveTeacherRoleGuard } from '@app/core/auth';
import { CoursesListComponent } from './components/list/list.component';
import { CourseFormComponent } from './components/form/form.component';

const routes: Routes = [
  {
    path: '',
    component: CoursesListComponent,
  },
  {
    path: 'create',
    component: CourseFormComponent,
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
    path: ':courseid/students',
    canLoad: [ShouldHaveTeacherRoleGuard],
    loadChildren: () => import('../progress/progress.module')
      .then(m => m.ProgressModule),
  },
  {
    path: ':courseid',
    component: CourseFormComponent,
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class CoursesRoutingModule {}
