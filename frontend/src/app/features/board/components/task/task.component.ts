import { ChangeDetectionStrategy, Component, Input } from '@angular/core';

import { BoardTask } from '../../types';

@Component({
  selector: 'app-task',
  templateUrl: './task.component.html',
  styleUrls: ['./task.component.scss'],
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export class TaskComponent {
  @Input() task!: BoardTask;
}
