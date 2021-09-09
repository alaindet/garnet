import { Component, Input } from '@angular/core';
import { Location } from '@angular/common';

import { Breadcrumb } from './breadcrumbs.type';

@Component({
  selector: 'app-breadcrumbs',
  templateUrl: './breadcrumbs.component.html',
  styleUrls: ['./breadcrumbs.component.scss'],
})
export class BreadcrumbsComponent {

  @Input() items!: Breadcrumb[];

  constructor(
    private location: Location,
  ) {}

  onBack(): void {
    this.location.back();
  }
}
