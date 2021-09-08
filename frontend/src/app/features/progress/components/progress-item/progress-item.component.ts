import { ChangeDetectionStrategy, Component, EventEmitter, Input, Output } from '@angular/core';

@Component({
  selector: 'app-progress-item',
  templateUrl: './progress-item.component.html',
  styleUrls: ['./progress-item.component.scss'],
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export class ProgressItemComponent {

  @Input() title!: string;
  @Input() badge!: string;
  @Input() todoCounter!: number;
  @Input() inProgressCounter!: number;
  @Input() doneCounter!: number;
  @Input() withClickableBadge = true;

  @Output() badgeClicked = new EventEmitter<void>();

  todoWidth!: string;
  inProgressWidth!: string;
  doneWidth!: string;

  ngOnInit(): void {
    const total = this.todoCounter + this.inProgressCounter + this.doneCounter;
    this.computeWidths(total);
  }

  onBadgeClicked(): void {
    if (this.withClickableBadge) {
      this.badgeClicked.emit();
    }
  }

  private computeWidths(total: number): void {
    this.todoWidth = (100 * this.todoCounter / total) + '%';
    this.inProgressWidth = 100 * (this.inProgressCounter / total) + '%';
    this.doneWidth = (100 * this.doneCounter / total) + '%';
  }
}
