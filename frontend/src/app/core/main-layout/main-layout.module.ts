import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';

import { MatIconModule } from '@angular/material/icon';
import { MatButtonModule } from '@angular/material/button';
import { MatSnackBarModule } from '@angular/material/snack-bar';

import { MainLayoutComponent } from './components/main-layout/main-layout.component';
import { NavbarComponent } from './components/navbar/navbar.component';
import { SidebarComponent } from './components/sidebar/sidebar.component';
import { SidebarToggleComponent } from './components/sidebar-toggle/sidebar-toggle.component';
import { FabComponent } from './components/fab/fab.component';
import { SnackbarComponent } from './components/snackbar/snackbar.component';

@NgModule({
  imports: [
    CommonModule,
    RouterModule,
    MatIconModule,
    MatButtonModule,
    MatSnackBarModule,
  ],
  declarations: [
    MainLayoutComponent,
    NavbarComponent,
    SidebarComponent,
    SidebarToggleComponent,
    FabComponent,
    SnackbarComponent,
  ],
  exports: [
    MainLayoutComponent,
  ],
})
export class MainLayoutComponentModule {}
