import { Component, HostBinding, Inject, OnInit } from '@angular/core';
import { MatSnackBarRef, MAT_SNACK_BAR_DATA } from '@angular/material/snack-bar';

import { SnackbarConfiguration } from '../../types';

@Component({
  templateUrl: './snackbar.component.html',
  styleUrls: ['./snackbar.component.scss'],
})
export class SnackbarComponent implements OnInit {

  constructor(
    public snackBarRef: MatSnackBarRef<SnackbarComponent>,
    @Inject(MAT_SNACK_BAR_DATA) public data: SnackbarConfiguration,
  ) {}

  ngOnInit(): void {
    this.cssClass = `--type-${this.data.type}`;
  }

  @HostBinding('class')
  cssClass!: string;
}
