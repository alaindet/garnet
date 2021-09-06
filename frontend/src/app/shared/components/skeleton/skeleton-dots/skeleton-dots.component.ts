import { ChangeDetectionStrategy, Component, Input } from '@angular/core';

@Component({
  selector: 'app-skeleton-dots',
  templateUrl: './skeleton-dots.component.html',
  styleUrls: ['./skeleton-dots.component.scss'],
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export class SkeletonDotsComponent {
  @Input() diameter = '2rem';
}
