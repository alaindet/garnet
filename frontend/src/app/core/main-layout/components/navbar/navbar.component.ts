import { ChangeDetectionStrategy, Component, ElementRef, Input, OnDestroy, OnInit, ViewChild } from '@angular/core';

import { UiService } from '../../services';

@Component({
  selector: 'app-navbar',
  templateUrl: './navbar.component.html',
  styleUrls: ['./navbar.component.scss'],
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export class NavbarComponent implements OnInit, OnDestroy {

  @Input() title!: string;

  @ViewChild('staticDummyRef', { static: true })
  staticDummyRef!: ElementRef;

  private observer?: IntersectionObserver;

  constructor(
    public ui: UiService,
  ) {}

  ngOnInit(): void {
    this.detachStickyNavbarOnScroll();
  }

  ngOnDestroy(): void {
    this.observer?.disconnect();
  }

  private detachStickyNavbarOnScroll(): void {

    const options = {
      root: null, // Root is viewport
      rootMargin: '0px',
      threshold: 0
    }

    const target = this.staticDummyRef.nativeElement;
    const callback = this.updateUiService.bind(this);
    const observer = new IntersectionObserver(callback, options);

    observer.observe(target);
  }

  private updateUiService(
    entries: IntersectionObserverEntry[],
    observer: IntersectionObserver,
  ): void {
    const dummyNavbar = entries[0];
    this.ui.isDummyNavbarVisible = dummyNavbar.isIntersecting;
  }
}
