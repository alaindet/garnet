import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, Routes } from '@angular/router';
import { ReactiveFormsModule } from '@angular/forms';

import { CardModule as PrimeCardModule } from 'primeng/card';
import { SkeletonModule as PrimeSkeletonModule } from 'primeng/skeleton';
import { ButtonModule as PrimeButtonModule } from 'primeng/button';

import { NavbarComponentModule } from '@app/core/components/navbar';
import { CoursesListComponent } from './components/list/list.component';
import { CreateCourseComponent } from './components/create/create.component';
import { CoursesService } from './services';

const routes: Routes = [
  {
    path: '',
    component: CoursesListComponent,
  },
  {
    path: 'create',
    component: CreateCourseComponent,
  },
];

@NgModule({
  imports: [
    CommonModule,
    RouterModule.forChild(routes),
    ReactiveFormsModule,
    PrimeCardModule,
    PrimeSkeletonModule,
    PrimeButtonModule,
    NavbarComponentModule,
  ],
  declarations: [
    CoursesListComponent,
    CreateCourseComponent,
  ],
  providers: [
    CoursesService,
  ],
})
export class CoursesModule {}
