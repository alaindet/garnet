import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

import { ShouldBeLoggedGuard, ShouldHaveStudentRoleGuard, ShouldHaveTeacherRoleGuard } from '@app/core/auth/guards';
import { MainLayoutComponent } from '@app/core/main-layout';

const DEFAULT_ROUTE = 'courses';

const routes: Routes = [
  {
    path: '',
    pathMatch: 'full',
    redirectTo: DEFAULT_ROUTE,
  },
  {
    path: '',
    canActivate: [ShouldBeLoggedGuard],
    canLoad: [ShouldBeLoggedGuard],
    component: MainLayoutComponent,
    children: [
      {
        path: 'courses',
        loadChildren: () => import('./features/courses/courses.module')
          .then(m => m.CoursesModule),
      },
      {
        path: 'board',
        loadChildren: () => import('./features/board/board.module')
        .then(m => m.BoardModule),
      },
      {
        path: 'progress',
        canLoad: [ShouldHaveTeacherRoleGuard],
        loadChildren: () => import('./features/progress/progress.module')
          .then(m => m.ProgressModule),
      },
      {
        path: 'task-manager',
        canLoad: [ShouldHaveTeacherRoleGuard],
        loadChildren: () => import('./features/task-manager/task-manager.module')
          .then(m => m.TaskManagerModule),
      },
      {
        path: 'profile',
        loadChildren: () => import('./features/profile/profile.module')
          .then(m => m.ProfileModule),
      },
      {
        path: 'invite',
        loadChildren: () => import('./features/invite/invite.module')
          .then(m => m.InviteModule),
      },
    ],
  },
  {
    path: 'auth',
    loadChildren: () => import('./core/auth/auth.module')
      .then(m => m.AuthModule),
  },
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule {}
