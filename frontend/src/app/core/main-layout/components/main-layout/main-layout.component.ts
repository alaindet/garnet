import { AfterViewInit, Component, ElementRef, ViewChild } from '@angular/core';
import { fromEvent } from 'rxjs';
import { throttleTime, map, distinctUntilChanged } from 'rxjs/operators';

import { UiService } from '../../services';
import { ScrollDirection } from '../../types';

@Component({
  selector: 'app-main-layout',
  templateUrl: './main-layout.component.html',
  styleUrls: ['./main-layout.component.scss'],
})
export class MainLayoutComponent implements AfterViewInit {

  @ViewChild('routerOutletRef')
  routerOutletRef!: ElementRef;

  constructor(
    public ui: UiService,
  ) {}

  ngAfterViewInit(): void {
    this.observeScrollingDirection();
  }

  private observeScrollingDirection(): void {
    let lastScrollY = window.scrollY;
    fromEvent(window, 'scroll')
      .pipe(
        // throttleTime(0, animationFrameScheduler),
        // throttleTime(1000 / 30), // 30 FPS
        throttleTime(1000 / 5), // 5 FPS
        map(() => {
          const isScrollingDown = (window.scrollY - lastScrollY) > 0;
          lastScrollY = window.scrollY;
          return isScrollingDown ? ScrollDirection.Down : ScrollDirection.Up;
        }),
        distinctUntilChanged(),
      )
      .subscribe(scrollDir => this.ui.scrollingDirection = scrollDir);
  }
}
