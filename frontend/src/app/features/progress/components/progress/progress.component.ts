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
  tabIndex = 0;
  tabsLoaded: { [name: string]: boolean } = {
    'By Student': true,
    'By Task': false,
  };

  constructor(
    public ui: UiService,
    private route: ActivatedRoute,
    private progressService: ProgressService,
  ) {}

  ngOnInit(): void {
    this.courseId = this.route.snapshot.params['courseid'];

    // TODO: Remove
    this.ui.title = '_COURSE_NAME_ - Progress by _FEATURE_';
    this.fetchProgressByTask();
  }

  onTabChange(tabIndex: number): void {
    this.tabIndex = tabIndex;
    const tabs = Object.keys(this.tabsLoaded);
    const tabName = tabs[tabIndex];
    this.tabsLoaded[tabName] = true;
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
