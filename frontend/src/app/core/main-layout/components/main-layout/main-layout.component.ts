import { AfterViewInit, Component, ElementRef, HostBinding, OnInit, OnDestroy, ViewChild } from '@angular/core';
import { fromEvent, Subscription } from 'rxjs';
import { throttleTime, map, distinctUntilChanged } from 'rxjs/operators';

import { UiService } from '../../services';
import { ScrollingDirection } from '../../types';

@Component({
  selector: 'app-main-layout',
  templateUrl: './main-layout.component.html',
  styleUrls: ['./main-layout.component.scss'],
})
export class MainLayoutComponent implements AfterViewInit, OnInit, OnDestroy {

  @ViewChild('routerOutletRef')
  routerOutletRef!: ElementRef;

  @HostBinding('class.--locked-scrolling')
  lockedScrolling = false;

  private subs: { [sub: string]: Subscription } = {};

  constructor(
    public ui: UiService,
  ) {}

  ngOnInit(): void {
    this.observeLockedScrolling();
  }

  ngAfterViewInit(): void {
    this.observeScrollingDirection();
  }

  ngOnDestroy(): void {
    for (const sub of Object.values(this.subs)) {
      sub.unsubscribe();
    }
  }

  onSidebarClose(): void {
    this.ui.isSidebarOpen = false;
  }

  private observeLockedScrolling(): void {
    this.subs.lockScrolling = this.ui.isSidebarOpen$
      .subscribe(isSidebarOpen => this.lockedScrolling = isSidebarOpen);
  }

  private observeScrollingDirection(): void {
    let lastScrollY = window.scrollY;
    this.subs.scrollingDirection = fromEvent(window, 'scroll')
      .pipe(
        throttleTime(1000 / 5), // 5 FPS
        map(() => {
          const isScrollingDown = (window.scrollY - lastScrollY) > 0;
          lastScrollY = window.scrollY;
          return isScrollingDown ? ScrollingDirection.Down : ScrollingDirection.Up;
        }),
        distinctUntilChanged(),
      )
      .subscribe(scrollDir => this.ui.scrollingDirection = scrollDir);
  }
}
