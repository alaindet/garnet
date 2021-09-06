import { AfterViewInit, Component, ElementRef, HostBinding, OnInit, OnDestroy, ViewChild, ChangeDetectorRef } from '@angular/core';
import { NavigationEnd, Router, ActivatedRoute } from '@angular/router';
import { combineLatest, fromEvent, Observable, Subscription } from 'rxjs';
import { throttleTime, map, distinctUntilChanged, filter, mergeMap, tap } from 'rxjs/operators';

import { environment } from '@environment/environment';
import { UiService } from '../../services';
import { FabConfiguration, ScrollingDirection } from '../../types';

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

  appName = environment.appName;
  fab$!: Observable<FabConfiguration | null>;
  loading$!: Observable<boolean>;

  private subs: { [sub: string]: Subscription } = {};

  constructor(
    public ui: UiService,
    private router: Router,
    private route: ActivatedRoute,
    private host: ElementRef,
    private cdr: ChangeDetectorRef,
  ) {}

  ngOnInit(): void {
    this.observeLockedScrolling();
    this.observeRouterEvents();
    this.observeUiUpdates();
  }

  ngAfterViewInit(): void {
    this.observeScrollingDirection();
  }

  ngOnDestroy(): void {
    for (const sub of Object.values(this.subs)) {
      sub.unsubscribe();
    }
  }

  private observeUiUpdates(): void {
    this.fab$ = this.ui.fab$;
    this.loading$ = this.ui.loading$;
    this.subs.uiUpdate = combineLatest([this.fab$, this.loading$])
      .subscribe(() => this.cdr.detectChanges());
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
      .pipe(
        filter(event => event instanceof NavigationEnd),
        tap(() => this.ui.isSidebarOpen = false),
      )
      .subscribe();
  }
}
