import { Component, OnInit } from '@angular/core';
import { finalize } from 'rxjs/operators';
import { MessageService as PrimeMessageService } from 'primeng/api';

import { CoursesService } from '../../services';
import { Course } from '../../types';

@Component({
  templateUrl: './courses.component.html',
  styleUrls: ['./courses.component.scss'],
  providers: [PrimeMessageService],
})
export class CoursesComponent implements OnInit {
 
  isLoading = false;
  courses: Course[] | null = null;
  studentHint = 'You follow this course';
  teacherHint = 'You teach this course';

  constructor(
    private coursesService: CoursesService,
    private messageService: PrimeMessageService,
  ) {}

  ngOnInit(): void {
    this.fetchCourses();
  }

  private fetchCourses(): void {

    this.isLoading = true;

    this.coursesService.getAllCourses()
      .pipe(finalize(() => this.isLoading = false))
      .subscribe({
        next: courses => this.courses = courses,
        error: err => {
          console.error(err);
          this.courses = null;
          this.messageService.add({
            severity: 'error',
            summary: 'Error',
            detail: err.error.message,
          });
        },
      });
  }
}