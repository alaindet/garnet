import { Injectable } from '@angular/core';

import { UserRole } from '../types';
import { ShouldHaveRoleGuard } from './should-have-role.guard';

@Injectable()
export class ShouldHaveStudentRoleGuard extends ShouldHaveRoleGuard {
  
  protected requiredRoles = [UserRole.Admin, UserRole.Student];
}
