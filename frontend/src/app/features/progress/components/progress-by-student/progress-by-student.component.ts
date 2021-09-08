import { Component, Input } from '@angular/core';
import { Router } from '@angular/router';
import { finalize } from 'rxjs/operators';

import { UiService } from '@app/core/main-layout/services';
import { ProgressService } from '../../services';
import { StudentProgress, ProgressItem } from '../../types';

@Component({
  selector: 'app-progress-by-student',
  templateUrl: './progress-by-student.component.html',
  styleUrls: ['./progress-by-student.component.scss'],
})
export class ProgressByStudentComponent {

  @Input() courseId!: string | number;

  items: ProgressItem[] = [];

  constructor(
    public ui: UiService,
    private progressService: ProgressService,
    private router: Router,
  ) {}

  ngOnInit(): void {
    this.ui.title = '_COURSE_NAME_ - Progress by _FEATURE_';
    this.fetchProgressByStudent();
  }

  onStudentClick(index: number): void {
    // ...
  }

  private fetchProgressByStudent(): void {
    this.ui.loading = true;
    this.progressService.getCourseProgressByStudent(this.courseId)
      .pipe(finalize(() => this.ui.loading = false))
      .subscribe({
        error: err => this.ui.setErrorToaster(err.error.message),
        next: students => this.items = students.map(this.mapProgressItem),
      });
  }

  private mapProgressItem(progress: StudentProgress): ProgressItem {
    return {
      title: `${progress.firstName} ${progress.lastName}`,
      badge: `${progress.firstName[0].toUpperCase()} ${progress.lastName[0].toUpperCase()}`,
      todoCounter: progress.tasksToDo,
      inProgressCounter: progress.tasksInProgress,
      doneCounter: progress.tasksDone,
    };
  }
}
