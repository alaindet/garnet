import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, Routes } from '@angular/router';
import { ReactiveFormsModule } from '@angular/forms';

import { MatIconModule } from '@angular/material/icon';
import { MatButtonModule } from '@angular/material/button';
import { MatCardModule } from '@angular/material/card';
import { MatMenuModule } from '@angular/material/menu';

import { CardModule as PrimeCardModule } from 'primeng/card';
import { SkeletonModule as PrimeSkeletonModule } from 'primeng/skeleton';
import { ButtonModule as PrimeButtonModule } from 'primeng/button';
import { InputTextModule as PrimeInputTextModule } from 'primeng/inputtext';
import { InputTextareaModule as PrimeInputTextareaModule } from 'primeng/inputtextarea';

import { CoursesListComponent } from './components/list/list.component';
import { CreateCourseComponent } from './components/create/create.component';
import { CoursesService } from './services';
import { CoursesAction } from './actions';

const routes: Routes = [
  {
    path: '',
    component: CoursesListComponent,
    data: { fab: CoursesAction.ShowCreateForm },
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
    PrimeInputTextModule,
    PrimeInputTextareaModule,
    MatIconModule,
    MatButtonModule,
    MatCardModule,
    MatMenuModule,
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
