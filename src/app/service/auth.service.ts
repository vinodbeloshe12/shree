import { Injectable } from '@angular/core';
import { Router, CanActivate, ActivatedRouteSnapshot, RouterStateSnapshot } from '@angular/router';
import { Observable } from 'rxjs';
import { UserService } from './user.service';
import { map, catchError } from 'rxjs/operators';
@Injectable({ providedIn: "root" })
export class AuthGuard implements CanActivate {


    constructor(private router: Router, private userService: UserService) {

    }

    canActivate(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): Observable<boolean> {

        return this.userService.getUserDetails().pipe(
            map((res: any) => {
                if (res.value) {
                    return true;
                } else {
                    this.router.navigate(['/login']);
                    return false;
                }
            })

        );
        // if (localStorage.getItem('loggedIn') && localStorage.getItem('loggedIn') == 'true') {
        //     // logged in so return true
        //     return true;
        // }
        // // not logged in so redirect to login page with the return url
        // this.router.navigate(['/login']);
        // return false;
    }

}