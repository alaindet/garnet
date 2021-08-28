import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, Routes } from '@angular/router';
import { ReactiveFormsModule } from '@angular/forms';
import { MatButtonModule } from '@angular/material/button';
import { MatCardModule } from '@angular/material/card';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatIconModule } from '@angular/material/icon';
import { MatInputModule } from '@angular/material/input';

import { BackButtonComponentModule } from '@app/shared/components/back-button';
import { SignInComponent } from './components/signin/signin.component';
import { SignOutComponent } from './components/signout/signout.component';
import { ShouldBeLoggedGuard, ShouldNotBeLoggedGuard } from './guards';

const routes: Routes = [
  {
    path: 'sign-in',
    canActivate: [ShouldNotBeLoggedGuard],
    component: SignInComponent,
  },
  {
    path: 'sign-out',
    canActivate: [ShouldBeLoggedGuard],
    component: SignOutComponent,
  },
];

@NgModule({
  imports: [
    CommonModule,
    RouterModule.forChild(routes),
    ReactiveFormsModule,
    MatButtonModule,
    MatCardModule,
    MatFormFieldModule,
    MatIconModule,
    MatInputModule,
    BackButtonComponentModule,
  ],
  declarations: [
    SignInComponent,
    SignOutComponent,
  ],
})
export class AuthModule {}
