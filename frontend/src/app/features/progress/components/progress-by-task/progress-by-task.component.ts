import { Component, Input } from '@angular/core';
import { finalize } from 'rxjs/operators';

import { UiService } from '@app/core/main-layout/services';
import { ProgressService } from '../../services';
import { TaskProgress, ProgressItem } from '../../types';

@Component({
  selector: 'app-progress-by-task',
  templateUrl: './progress-by-task.component.html',
  styleUrls: ['./progress-by-task.component.scss'],
})
export class ProgressByTaskComponent {

  @Input() courseId!: string | number;

  items: ProgressItem[] = [];

  constructor(
    public ui: UiService,
    private progressService: ProgressService,
  ) { }

  ngOnInit(): void {
    this.fetchProgressByTask();
  }

  private fetchProgressByTask(): void {
    this.ui.loading = true;
    this.progressService.getCourseProgressByTask(this.courseId)
      .pipe(finalize(() => this.ui.loading = false))
      .subscribe({
        error: err => this.ui.setErrorToaster(err.error.message),
        next: students => this.items = students.map(this.mapProgressItem),
      });
  }

  private mapProgressItem(progress: TaskProgress): ProgressItem {
    return {
      title: `${progress.taskName} - ${progress.taskDescription}`,
      badge: ''+progress.taskId,
      todoCounter: progress.studentsToDo,
      inProgressCounter: progress.studentsInProgress,
      doneCounter: progress.studentsDone,
    };
  }
}
