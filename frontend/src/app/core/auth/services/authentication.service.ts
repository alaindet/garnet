import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { tap } from 'rxjs/operators';

import { environment } from '@environment/environment';
import { SignInDto, SignInResponse } from '../types';
import { JwtService } from './jwt.service';

@Injectable({
  providedIn: 'root',
})
export class AuthenticationService {

  constructor(
    private http: HttpClient,
    private jwtService: JwtService,
  ) {}

  signIn(dto: SignInDto): Observable<SignInResponse> {
    const url = `${environment.apiUrl}/auth/signin`;
    return this.http.post<SignInResponse>(url, dto)
      .pipe(tap(res => {
        this.jwtService.store(res.data.jwt);
      }));
  }

  signOut(): void {
    this.jwtService.clear();
  }

  isSignedIn(): boolean {
    return this.jwtService.hasExpired();
  }
}
