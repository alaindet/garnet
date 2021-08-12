import { Component, OnInit } from '@angular/core';
import { finalize } from 'rxjs/operators';
import { Title } from '@angular/platform-browser';

import { MessageService as PrimeMessageService } from 'primeng/api';
import { CoursesService } from '../../services';
import { Course } from '../../types';
import { UiService } from '@app/core/main-layout/services';

@Component({
  templateUrl: './list.component.html',
  styleUrls: ['./list.component.scss'],
  providers: [PrimeMessageService],
})
export class CoursesListComponent implements OnInit {

  isLoading = false;
  courses: Course[] | null = null;
  studentHint = 'You follow this course';
  teacherHint = 'You teach this course';

  constructor(
    private coursesService: CoursesService,
    private messageService: PrimeMessageService,
    private titleService: Title,
    private ui: UiService,
  ) {}

  ngOnInit(): void {
    this.ui.setTitle('Courses');
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
