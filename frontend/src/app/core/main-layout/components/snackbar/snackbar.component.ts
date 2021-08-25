import { Component, ElementRef, HostBinding, Inject, OnInit, ViewChild } from '@angular/core';
import { MatSnackBarRef, MAT_SNACK_BAR_DATA } from '@angular/material/snack-bar';

import { SnackbarConfiguration } from '../../types';

@Component({
  templateUrl: './snackbar.component.html',
  styleUrls: ['./snackbar.component.scss'],
})
export class SnackbarComponent implements OnInit {

  @ViewChild('messageRef', { static: true })
  messageRef!: ElementRef;

  constructor(
    public snackBarRef: MatSnackBarRef<SnackbarComponent>,
    @Inject(MAT_SNACK_BAR_DATA) public data: SnackbarConfiguration,
    private host: ElementRef,
  ) {}

  ngOnInit(): void {
    this.cssClass = `--type-${this.data.type}`;
  }

  ngAfterViewInit(): void {
    setTimeout(() => {
      const rect: DOMRect = this.messageRef.nativeElement.getBoundingClientRect();
      // console.log('rect.height * 1.1', rect.height * 1.1);
      this.host.nativeElement.style.height = (rect.height + 16) + 'px';
    }, 200);
  }

  @HostBinding('class')
  cssClass!: string;
}
