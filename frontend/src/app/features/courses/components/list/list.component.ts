import { Component, OnDestroy, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { finalize } from 'rxjs/operators';
import { Subscription } from 'rxjs';

import { UiService } from '@app/core/main-layout/services';
import { MessageService as PrimeMessageService } from 'primeng/api';
import { CoursesService } from '../../services';
import { Course } from '../../types';
import { CoursesAction } from '../../actions';

@Component({
  templateUrl: './list.component.html',
  styleUrls: ['./list.component.scss'],
  providers: [PrimeMessageService],
})
export class CoursesListComponent implements OnInit, OnDestroy {

  CoursesAction = CoursesAction;
  isLoading = false;
  courses: Course[] | null = null;

  private subs: { [sub: string]: Subscription } = {};

  constructor(
    private coursesService: CoursesService,
    private messageService: PrimeMessageService,
    private ui: UiService,
    private router: Router,
  ) {}

  ngOnInit(): void {
    this.ui.title = 'Courses';
    this.fetchCourses();
    this.subs.fab = this.ui.fabClicked$.subscribe(this.onFabClick.bind(this));
  }

  ngOnDestroy(): void {
    for (const sub of Object.values(this.subs)) {
      sub.unsubscribe();
    }
  }

  onMenuActionClicked(action: CoursesAction): void {
    switch (action) {
      case CoursesAction.EditTasks:
        console.log(CoursesAction.EditTasks);
        // ...
        break;
      case CoursesAction.EditCourse:
        console.log(CoursesAction.EditCourse);
        // ...
        break;
      case CoursesAction.ShowDeleteConfirmation:
        console.log(CoursesAction.ShowDeleteConfirmation);
        // ...
        break;
    }
  }

  onShowStudents(): void {
    console.log(CoursesAction.ShowStudents);
  }

  onFabClick(action: string): void {
    if (action === CoursesAction.ShowCreateForm) {
      this.router.navigate(['/courses/create']);
    }
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
