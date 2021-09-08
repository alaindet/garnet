import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { finalize, tap } from 'rxjs/operators';

import { UiService } from '@app/core/main-layout/services';
import { ProgressService } from '../../services';

@Component({
  templateUrl: './progress.component.html',
  styleUrls: ['./progress.component.scss'],
})
export class ProgressComponent implements OnInit {

  courseId!: string | number;

  constructor(
    public ui: UiService,
    private route: ActivatedRoute,
    private progressService: ProgressService,
  ) {}

  ngOnInit(): void {
    this.courseId = this.route.snapshot.params['courseid'];

    // TODO: Remove
    this.ui.title = '_COURSE_NAME_ - Progress by _FEATURE_';
    this.fetchProgressByStudent();
    this.fetchProgressByTask();
  }

  private fetchProgressByStudent(): void {
    this.ui.loading = true;
    this.progressService.getCourseProgressByStudent(this.courseId)
      .pipe(finalize(() => this.ui.loading = false))
      .subscribe({
        error: err => this.ui.setErrorToaster(err.error.message),
        next: students => {
          console.log('students', students);
        },
      });
  }

  private fetchProgressByTask(): void {
    this.ui.loading = true;
    this.progressService.getCourseProgressByTask(this.courseId)
      .pipe(finalize(() => this.ui.loading = false))
      .subscribe({
        error: err => this.ui.setErrorToaster(err.error.message),
        next: tasks => {
          console.log('tasks', tasks);
        },
      });
  }
}
