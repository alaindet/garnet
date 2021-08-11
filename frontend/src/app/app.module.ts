import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { HttpClientModule } from '@angular/common/http';

import { AuthModule } from '@app/core/auth';
import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { ShouldBeLoggedGuard, ShouldNotBeLoggedGuard } from '@app/core/auth';

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

  ],
  providers: [
    ShouldBeLoggedGuard,
    ShouldNotBeLoggedGuard,
  ],
  bootstrap: [AppComponent],
})
export class AppModule {}
