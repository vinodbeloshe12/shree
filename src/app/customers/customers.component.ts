import { Component, OnInit } from '@angular/core';
import { trigger, style, animate, transition } from "@angular/animations";
import { UserService } from '../service/user.service';
import { idproof } from '../app.constants';
import { Router } from '@angular/router';

@Component({
  selector: 'app-customers',
  templateUrl: './customers.component.html',
  styleUrls: ['./customers.component.less'],
  animations: [
    trigger(
      'myAnimation', [
      transition(':enter', [
        style({ transform: 'translateX(100%)', opacity: 0 }),
        animate('500ms', style({ transform: 'translateX(0)', opacity: 1 }))
      ]),
      transition(':leave', [
        style({ transform: 'translateX(0)', 'opacity': 1 }),
        animate('500ms', style({ transform: 'translateX(100%)', opacity: 0 }))
      ]),
    ]
    )
  ],
})
export class CustomersComponent implements OnInit {
  customers: any = [];
  customerData: any = {};
  isShow = false;
  isEditShow = false;
  isDisabled = false;
  addKYC = false;
  emailValidate: boolean;
  id = idproof;
  idproof = {};
  idproofData: any = [];
  selectedId = {};
  imageName: any = [];
  image;
  constructor(private userService: UserService, private router: Router) { }

  ngOnInit() {
    this.getAllCustomers();
  }

  toggleDisplay() {
    this.isShow = !this.isShow;
  }
  toggleEditDisplay() {
    this.isEditShow = !this.isEditShow;
  }

  getAllCustomers() {
    this.userService.getAllCustomers().subscribe((res: any) => {
      if (res.value) {
        this.customers = res.data;
      }
    }, err => console.log(err));

  }

  navigateToCustomer(id) {
    this.router.navigate(['customerdetails', id])
  }
}

