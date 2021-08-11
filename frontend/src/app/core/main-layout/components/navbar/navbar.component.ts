import { AfterViewInit, ChangeDetectionStrategy, Component, ElementRef, Input, ViewChild } from '@angular/core';

@Component({
  selector: 'app-navbar',
  templateUrl: './navbar.component.html',
  styleUrls: ['./navbar.component.scss'],
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export class NavbarComponent implements AfterViewInit {

  @Input() title: string | null = '';

  @ViewChild('staticDummyRef')
  staticDummyRef!: ElementRef;

  ngAfterViewInit(): void {
    this.detachStickyNavbarOnScroll();
  }

  private detachStickyNavbarOnScroll(): void {

    const options = {
      // root: document.querySelector('#scrollArea'),
      root: null, // Viewport
      rootMargin: '0px',
      threshold: 0
    }

    const target = this.staticDummyRef.nativeElement;

    const callback = (
      entries: IntersectionObserverEntry[],
      observer: IntersectionObserver,
    ) => {
      const dummyNavbar = entries[0];
      console.log('isIntersecting', dummyNavbar.isIntersecting);
      // observer.unobserve(target);
    };

    const observer = new IntersectionObserver(callback, options);

    observer.observe(target);
  }
}
