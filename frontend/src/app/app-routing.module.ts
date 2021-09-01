import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

import { ShouldBeLoggedGuard } from '@app/core/auth/guards';
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
