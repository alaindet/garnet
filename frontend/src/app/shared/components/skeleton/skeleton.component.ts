import { Component, Input, HostBinding } from '@angular/core';

@Component({
  selector: 'app-skeleton',
  styleUrls: ['./skeleton.component.scss'],
  template: '',
})
export class SkeletonComponent {

  @Input()
  @HostBinding('style.width')
  width = '100%';

  @Input()
  @HostBinding('style.height')
  height = '1rem';

  @Input()
  set rounded(rounded: '' | boolean) {
    const isRounded = !!rounded || rounded === '';
    if (isRounded) {
      this.borderRadius = '1rem';
    }
  }

  @Input() circle: string | null = null;

  @Input() square: string | null = null;

  @HostBinding('style.border-radius')
  borderRadius = '0';

  @HostBinding('class')
  cssClass = '';

  ngOnInit(): void {

    if (this.circle !== null) {
      this.width = this.circle;
      this.height = this.circle;
      this.cssClass = '--circle';
      return;
    }

    if (this.square) {
      this.width = this.square;
      this.height = this.square;
    }
    
    if (this.rounded) {
      this.cssClass = '--rounded';
    }
  }
}
