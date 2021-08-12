import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, Routes } from '@angular/router';
import { ReactiveFormsModule } from '@angular/forms';

// Prime NG
import { CardModule as PrimeCardModule } from 'primeng/card';
import { ButtonModule as PrimeButtonModule } from 'primeng/button';
import { InputTextModule as PrimeInputTextModule } from 'primeng/inputtext';
import { ToastModule as PrimeToastModule } from 'primeng/toast';

// App
import { SignInComponent } from './components/signin/signin.component';
import { SignOutComponent } from './components/signout/signout.component';
import { AuthenticationService } from './services';
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

    // Prime NG
    PrimeCardModule,
    PrimeButtonModule,
    PrimeInputTextModule,
    PrimeToastModule,
  ],
  declarations: [
    SignInComponent,
    SignOutComponent,
  ],
  providers: [
    AuthenticationService,
  ],
})
export class AuthModule {}
