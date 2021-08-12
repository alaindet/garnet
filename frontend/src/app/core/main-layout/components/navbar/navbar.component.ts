import { AfterViewInit, ChangeDetectionStrategy, Component, ElementRef, Input, OnDestroy, ViewChild } from '@angular/core';

import { UiService } from '../../services';

@Component({
  selector: 'app-navbar',
  templateUrl: './navbar.component.html',
  styleUrls: ['./navbar.component.scss'],
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export class NavbarComponent implements AfterViewInit, OnDestroy {

  @Input() title: string | null = '';

  @ViewChild('staticDummyRef')
  staticDummyRef!: ElementRef;

  private observer?: IntersectionObserver;

  constructor(
    public ui: UiService,
  ) {}

  ngAfterViewInit(): void {
    this.detachStickyNavbarOnScroll();

    // TODO: Remove
    this.ui.isNavbarSticky$.subscribe(x => console.log('isNavbarSticky', x));
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
