import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

import { ShouldBeLoggedGuard } from './core/auth/guards/should-be-logged.guard';

const routes: Routes = [
  {
    path: '',
    pathMatch: 'full',
    redirectTo: 'profile',
  },
  {
    path: 'profile',
    canLoad: [ShouldBeLoggedGuard],
    loadChildren: () => import('./features/profile/profile.module')
      .then(m => m.ProfileModule),
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
