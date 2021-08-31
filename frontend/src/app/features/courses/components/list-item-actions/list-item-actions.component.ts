import { ChangeDetectionStrategy, Component, EventEmitter, Input, Output, ViewEncapsulation } from '@angular/core';

import { UserRole } from '@app/core/auth/types';

@Component({
  selector: 'app-list-item-actions',
  templateUrl: './list-item-actions.component.html',
  styleUrls: ['./list-item-actions.component.scss'],
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export class CoursesListItemActionsComponent {

  @Input() userRole!: UserRole;

  @Output() showStudents = new EventEmitter<void>();
  @Output() showBoard = new EventEmitter<void>();
  @Output() editTasks = new EventEmitter<number | string>();
  @Output() editCourse = new EventEmitter<number | string>();
  @Output() deleteCourse = new EventEmitter<number | string>();
  @Output() leaveCourse = new EventEmitter<number | string>();

  UserRole = UserRole;
}
