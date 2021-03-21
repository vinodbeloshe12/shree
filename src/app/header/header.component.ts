import { Component, OnInit } from '@angular/core';
import { UserService } from '../service/user.service';
import { Router } from '@angular/router';
@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.less']
})
export class HeaderComponent implements OnInit {
  customers: any = [];
  customerData: any = {};
  sidebarnav: boolean = false;
  userName: String = "";
  constructor(private userService: UserService, private router: Router) { }


  ngOnInit() {
    // this.getAllCustomers();
    this.userName = localStorage.getItem('userData') ? JSON.parse(localStorage.getItem('userData')).first_name : '';
  }


  Opensidebar() {
    this.sidebarnav = true;
  }

  Closesidebar() {
    this.sidebarnav = false;
  }

  logout() {
    this, this.userService.logout().subscribe((res: any) => {
      if (res.value) {
        this.router.navigate(['/login']);
      }
    });
  }

  // getAllCustomers() {
  //   this.userService.getAllCustomers().subscribe((res: any) => {
  //     this.customers = res.data;
  //   });

  // }

}
