import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

import { environment } from '@environment/environment';
import { SignInDto } from '../types';

@Injectable()
export class SignInService {

  constructor(
    private http: HttpClient,
  ) {}

  signIn(dto: SignInDto): Observable<any> {
    const url = environment.apiUrl + '/auth/signin';
    return this.http.post(url, dto);
  }
}