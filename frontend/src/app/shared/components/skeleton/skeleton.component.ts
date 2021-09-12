import { Component, Input, HostBinding, ChangeDetectionStrategy } from '@angular/core';

@Component({
  selector: 'app-skeleton',
  template: '',
  styleUrls: ['./skeleton.component.scss'],
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export class SkeletonComponent {

  @Input() width = '100%';
  @Input() height = '1rem';
  @Input() rounded: string | null = null;
  @Input() circle: string | null = null;
  @Input() square: string | null = null;

  @HostBinding('style')
  cssStyle: { [rule: string]: any } = {};

  ngOnInit(): void {

    if (this.circle !== null) {
      this.cssStyle.width = this.circle;
      this.cssStyle.height = this.circle;
      this.cssStyle.borderRadius = '100%';
      return;
    }

    if (this.square) {
      this.cssStyle.width = this.square;
      this.cssStyle.height = this.square;
    }

    if (this.rounded || this.rounded === '') {
      this.cssStyle.borderRadius = (this.rounded === '') ? '1rem' : this.rounded;
    }

    this.cssStyle.width = this.width;
    this.cssStyle.height = this.height;
  }
}
