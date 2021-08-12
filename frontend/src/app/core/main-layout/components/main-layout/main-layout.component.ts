import { AfterViewInit, Component, ElementRef, ViewChild } from '@angular/core';
import { fromEvent } from 'rxjs';
import { throttleTime, map, distinctUntilChanged } from 'rxjs/operators';

import { UiService } from '../../services';
import { ScrollingDirection } from '../../types';

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

  onSidebarClose(): void {
    this.ui.isSidebarOpen = false;
    console.log('onSidebarClose()');
  }

  private observeScrollingDirection(): void {
    let lastScrollY = window.scrollY;
    fromEvent(window, 'scroll')
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
