import { Component, ElementRef, HostBinding, OnInit, OnDestroy, ViewChild, ChangeDetectorRef } from '@angular/core';
import { NavigationEnd, Router } from '@angular/router';
import { fromEvent, Subscription } from 'rxjs';
import { throttleTime, map, distinctUntilChanged, filter, delay } from 'rxjs/operators';

import { environment } from '@environment/environment';
import { UiService } from '../../services';
import { FabConfiguration, ScrollingDirection } from '../../types';
import { Breadcrumb } from '@app/shared/components/breadcrumbs';

@Component({
  selector: 'app-main-layout',
  templateUrl: './main-layout.component.html',
  styleUrls: ['./main-layout.component.scss'],
})
export class MainLayoutComponent implements OnInit, OnDestroy {

  @ViewChild('routerOutletRef')
  routerOutletRef!: ElementRef;

  @HostBinding('class.--locked-scrolling')
  lockedScrolling = false;

  appName = environment.appName;

  uiBreadcrumbs: Breadcrumb[] = [];
  uiFab: FabConfiguration | null = null;
  uiLoading = false;
  uiIsSidebarOpen = false;

  private subs: { [sub: string]: Subscription } = {};

  constructor(
    public ui: UiService,
    private router: Router,
    private host: ElementRef,
  ) {}

  ngOnInit(): void {
    this.observeLockedScrolling();
    this.observeRouterEvents();
    this.observeScrollingDirection();
    this.observeUiUpdates();
  }

  ngOnDestroy(): void {
    for (const sub of Object.values(this.subs)) {
      sub.unsubscribe();
    }
  }

  onFabClicked(): void {
    if (this.uiFab) {
      this.ui.clickFab(this.uiFab.actionName);
    }
  }

  onDismissSidebar(): void {
    this.ui.isSidebarOpen = false;
  }

  private observeUiUpdates(): void {
    this.subs.breacrumbds = this.ui.breadcrumbs$
      .pipe(delay(0), filter(val => val !== null))
      .subscribe(breadcrumbs => this.uiBreadcrumbs = breadcrumbs);

    this.subs.fab = this.ui.fab$
      .pipe(delay(0))
      .subscribe(fab => this.uiFab = fab);

    this.subs.loading = this.ui.loading$
      .pipe(delay(0), filter(val => val !== null))
      .subscribe(loading => this.uiLoading = loading);

    this.subs.isSidebarOpen = this.ui.isSidebarOpen$
      .pipe(delay(0), filter(val => val !== null))
      .subscribe(isSidebarOpen => this.uiIsSidebarOpen = isSidebarOpen);
  }

  private observeLockedScrolling(): void {
    this.subs.lockScrolling = this.ui.isSidebarOpen$
      .subscribe(isSidebarOpen => this.lockedScrolling = isSidebarOpen);
  }

  private observeScrollingDirection(): void {
    let lastScrollY = this.host.nativeElement.scrollTop;
    this.subs.scrollingDirection = fromEvent(this.host.nativeElement, 'scroll')
      .pipe(
        throttleTime(1000 / 5), // 5 FPS
        map(() => {
          const scrolled = this.host.nativeElement.scrollTop;
          const isScrollingDown = (scrolled - lastScrollY) > 0;
          lastScrollY = scrolled;
          return isScrollingDown ? ScrollingDirection.Down : ScrollingDirection.Up;
        }),
        distinctUntilChanged(),
      )
      .subscribe(scrollDir => this.ui.scrollingDirection = scrollDir);
  }

  private observeRouterEvents(): void {
    this.router.events
      .pipe(filter(event => event instanceof NavigationEnd))
      .subscribe(() => {
        this.ui.isSidebarOpen = false;
        this.ui.fab = null;
        this.ui.clearLoading();
      });
  }
}
