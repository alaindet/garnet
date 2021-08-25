import { Component, ElementRef, HostBinding, Inject, OnInit, ViewChild, Renderer2 } from '@angular/core';
import { MatSnackBarRef, MAT_SNACK_BAR_DATA } from '@angular/material/snack-bar';

import { SnackbarConfiguration } from '../../types';

@Component({
  templateUrl: './snackbar.component.html',
  styleUrls: ['./snackbar.component.scss'],
})
export class SnackbarComponent implements OnInit {

  @ViewChild('messageRef', { static: true })
  messageRef!: ElementRef;

  private heightThreshold = 42;

  constructor(
    public snackBarRef: MatSnackBarRef<SnackbarComponent>,
    @Inject(MAT_SNACK_BAR_DATA) public data: SnackbarConfiguration,
    private host: ElementRef,
    private renderer: Renderer2,
  ) {}

  ngOnInit(): void {
    this.cssClass = `--type-${this.data.type}`;
  }

  ngAfterViewInit(): void {
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
