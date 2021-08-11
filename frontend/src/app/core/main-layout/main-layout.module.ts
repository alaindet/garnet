import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';

import { MainLayoutComponent } from './components/main-layout/main-layout.component';
import { NavbarComponent } from './components/navbar/navbar.component';
import { SidebarComponent } from './components/sidebar/sidebar.component';
import { SidebarToggleComponent } from './components/sidebar-toggle/sidebar-toggle.component';

@NgModule({
  imports: [
    CommonModule,
    RouterModule,
  ],
  declarations: [
    MainLayoutComponent,
    NavbarComponent,
    SidebarComponent,
    SidebarToggleComponent,
  ],
  exports: [
    MainLayoutComponent,
  ],
})
export class MainLayoutComponentModule {}
