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

  constructor(private userService: UserService, private router: Router) { }
  

  ngOnInit() {
    // this.getAllCustomers();
  }

  // getAllCustomers() {
  //   this.userService.getAllCustomers().subscribe((res: any) => {
  //     this.customers = res.data;
  //   });

  // }

}
