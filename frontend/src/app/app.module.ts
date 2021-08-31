import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { HttpClientModule } from '@angular/common/http';

import { AuthModule } from '@app/core/auth';
import { ToasterComponentModule } from '@app/shared/components/toaster';
import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { ShouldBeLoggedGuard, ShouldNotBeLoggedGuard, ShouldHaveTeacherRoleGuard, ShouldHaveStudentRoleGuard } from '@app/core/auth';
import { MainLayoutComponentModule } from '@app/core/main-layout';

@NgModule({
  declarations: [
    AppComponent
  ],
  imports: [
    BrowserModule,
    BrowserAnimationsModule,
    HttpClientModule,
    AppRoutingModule,
    AuthModule,
    MainLayoutComponentModule,
    ToasterComponentModule,
  ],
  providers: [
    ShouldBeLoggedGuard,
    ShouldNotBeLoggedGuard,
    ShouldHaveTeacherRoleGuard,
    ShouldHaveStudentRoleGuard,
  ],
  bootstrap: [AppComponent],
})
export class AppModule {}
