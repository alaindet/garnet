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
import { AuthenticationService } from './services';

const routes: Routes = [
  {
    path: 'sign-in',
    component: SignInComponent,
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
  ],
  exports: [
    SignInComponent,
  ],
  providers: [
    AuthenticationService,
  ],
})
export class AuthModule {}