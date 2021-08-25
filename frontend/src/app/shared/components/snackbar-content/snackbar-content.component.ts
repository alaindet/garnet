import { Component, ElementRef, HostBinding, Inject, OnInit, ViewChild, Renderer2 } from '@angular/core';
import { MatSnackBarRef, MAT_SNACK_BAR_DATA } from '@angular/material/snack-bar';

import { SnackbarContentConfig } from './snackbar-content-config.type';

@Component({
  templateUrl: './snackbar-content.component.html',
  styleUrls: ['./snackbar-content.component.scss'],
})
export class SnackbarContentComponent implements OnInit {

  @ViewChild('messageRef', { static: true })
  messageRef!: ElementRef;

  private heightThreshold = 42;

  constructor(
    public snackBarRef: MatSnackBarRef<SnackbarContentComponent>,
    @Inject(MAT_SNACK_BAR_DATA) public data: SnackbarContentConfig,
    private host: ElementRef,
    private renderer: Renderer2,
  ) {}

  ngOnInit(): void {
    this.cssClass = `--type-${this.data.type}`;
  }

  ngAfterViewInit(): void {
    // UGLY: Adjust height at runtime
    setTimeout(() => {
      this.renderer.setStyle(this.host.nativeElement, 'height', '100%');
      const messageEl = this.messageRef.nativeElement;
      const rect: DOMRect = messageEl.getBoundingClientRect();
      const height = rect.height + 24;
      if (height > this.heightThreshold) {
        this.renderer.setStyle(this.host.nativeElement, 'height', height + 'px');
      }
    }, 100);
  }

  @HostBinding('class')
  cssClass!: string;
}
