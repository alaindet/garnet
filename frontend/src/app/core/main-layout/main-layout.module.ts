import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';

import { MatIconModule } from '@angular/material/icon';
import { MatButtonModule } from '@angular/material/button';
import { MatProgressBarModule } from '@angular/material/progress-bar';

import { BreadcrumbsComponentModule } from '@app/shared/components/breadcrumbs';
import { MainLayoutComponent } from './components/main-layout/main-layout.component';
import { NavbarComponent } from './components/navbar/navbar.component';
import { SidebarComponent } from './components/sidebar/sidebar.component';
import { SidebarToggleComponent } from './components/sidebar-toggle/sidebar-toggle.component';
import { FabComponent } from './components/fab/fab.component';

@NgModule({
  imports: [
    CommonModule,
    RouterModule,
    MatIconModule,
    MatButtonModule,
    MatProgressBarModule,
    BreadcrumbsComponentModule,
  ],
  declarations: [
    MainLayoutComponent,
    NavbarComponent,
    SidebarComponent,
    SidebarToggleComponent,
    FabComponent,
  ],
  exports: [
    MainLayoutComponent,
  ],
})
export class MainLayoutComponentModule {}
