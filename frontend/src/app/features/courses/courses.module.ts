import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, Routes } from '@angular/router';
import { ReactiveFormsModule } from '@angular/forms';

import { CardModule as PrimeCardModule } from 'primeng/card';
import { SkeletonModule as PrimeSkeletonModule } from 'primeng/skeleton';

import { CoursesComponent } from './components/courses/courses.component';
import { CoursesService } from './services';

const routes: Routes = [
  {
    path: '',
    component: CoursesComponent,
  },
];

@NgModule({
  imports: [
    CommonModule,
    RouterModule.forChild(routes),
    ReactiveFormsModule,
    PrimeCardModule,
    PrimeSkeletonModule,
  ],
  declarations: [
    CoursesComponent,
  ],
  providers: [
    CoursesService,
  ],
})
export class CoursesModule {}