import { Component, OnInit } from '@angular/core';
import { LoginService } from '../service/login.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.less']
})
export class LoginComponent implements OnInit {
  userData: any = {};
  constructor(private loginService: LoginService, private router: Router) { }

  ngOnInit() {
  }

  login(data) {
    this.loginService.login(data).subscribe((res: any) => {
      if (res.value) {
        localStorage.setItem("userData", JSON.stringify(res.data));
        localStorage.setItem("loggedIn", 'true');
        this.router.navigate(['dashboard']);
      } else {
        alert("please enter valid Username/Passowrd");
      }
    }, err => console.log(err));
  }
}
