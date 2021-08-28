import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { tap } from 'rxjs/operators';

import { environment } from '@environment/environment';
import { JwtDecodedInfo, SignInDto, SignInResponse } from '../types';
import { JwtService } from './jwt.service';
import { UserInfoService } from './user-info.service';

@Injectable({
  providedIn: 'root',
})
export class AuthenticationService {

  constructor(
    private http: HttpClient,
    private jwtService: JwtService,
    private userInfo: UserInfoService,
  ) {}

  signIn(dto: SignInDto): Observable<SignInResponse> {
    const url = `${environment.apiUrl}/auth/signin`;
    return this.http.post<SignInResponse>(url, dto).pipe(tap(this.onSignIn));
  }

  signOut(): void {
    this.jwtService.clear();
  }

  isSignedIn(): boolean {
    return this.jwtService.hasExpired();
  }

  private onSignIn(res: SignInResponse): void {
    const jwt = res.data.jwt;
    const parsedJwt = this.jwtService.parseJwt(jwt) as JwtDecodedInfo;
    this.userInfo.id = parsedJwt.sub;
    const userRoleKey = `${environment.appSlug}.role`;
    this.userInfo.role = parsedJwt[userRoleKey];
    this.jwtService.store(res.data.jwt);
  }
}
