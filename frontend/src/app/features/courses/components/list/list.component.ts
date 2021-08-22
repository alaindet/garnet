import { Component, OnDestroy, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { finalize } from 'rxjs/operators';
import { Subscription } from 'rxjs';
import { MatDialog, MatDialogConfig } from '@angular/material/dialog';

import { UiService } from '@app/core/main-layout/services';
import { CoursesService } from '../../services';
import { Course } from '../../types';
import { CoursesAction } from '../../actions';
import { ConfirmDeleteComponent } from '../confirm-delete/confirm-delete.component';

@Component({
  templateUrl: './list.component.html',
  styleUrls: ['./list.component.scss'],
})
export class CoursesListComponent implements OnInit, OnDestroy {

  CoursesAction = CoursesAction;
  isLoading = false;
  courses: Course[] | null = null;

  private subs: { [sub: string]: Subscription } = {};

  constructor(
    private coursesService: CoursesService,
    private ui: UiService,
    private router: Router,
    private matDialog: MatDialog,
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

  onMenuActionClicked(action: CoursesAction, courseId: number): void {
    switch (action) {
      case CoursesAction.EditTasks:
        console.log(CoursesAction.EditTasks, courseId);
        // ...
        break;
      case CoursesAction.ShowEditCourseForm:
        this.router.navigate(['/courses', courseId]);
        break;
      case CoursesAction.ShowDeleteCourse:
        this.deleteCourse(courseId);
        break;
    }
  }

  onShowStudents(): void {
    console.log(CoursesAction.ShowStudents);
    // ...
  }

  onFabClick(action: string): void {
    if (action === CoursesAction.ShowCreateCourseForm) {
      this.router.navigate(['/courses/create']);
    }
  }

  private fetchCourses(): void {

    this.isLoading = true;

    this.coursesService.getAllCourses()
      .pipe(finalize(() => this.isLoading = false))
      .subscribe({
        error: err => this.ui.setSnackbarError(err.error.message),
        next: courses => this.courses = courses,
      });
  }

  private deleteCourse(courseId: number): void {
    const course = this.courses?.find(c => c.course_id === courseId);
    const config: MatDialogConfig<Course> = { data: course };
    this.matDialog.open(ConfirmDeleteComponent, config)
      .afterClosed()
      .subscribe(data => {
        if (data) {
          this.fetchCourses();
        }
      });
  }
}
