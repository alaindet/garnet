import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { BoardRoutingModule } from './board.routing.module';
import { BoardComponentsModule } from './board.components.module';
import { BoardComponent, TaskComponent } from './components';
import { TasksService } from './services';

@NgModule({
  imports: [
    CommonModule,
    BoardRoutingModule,
    BoardComponentsModule,
  ],
  declarations: [
    BoardComponent,
    TaskComponent,
  ],
  providers: [
    TasksService,
  ],
})
export class BoardModule {}
