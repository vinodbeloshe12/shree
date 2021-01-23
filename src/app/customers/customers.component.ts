import { Component, OnInit } from '@angular/core';
import { trigger, style, animate, transition } from "@angular/animations";
import { UserService } from '../service/user.service';
import { idproof } from '../app.constants';
import { Router } from '@angular/router';
import * as moment from 'moment';
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
  image: any;
  constructor(private userService: UserService, private router: Router) { }

  ngOnInit() {
    this.getAllUserData();
  }

  toggleDisplay() {
    this.isShow = !this.isShow;
  }
  toggleEditDisplay() {
    this.isEditShow = !this.isEditShow;
  }

  getAllUserData(){
    this.userService.getAllUserData().subscribe((res:any)=>{
      this.customers=res.data;
    })
  }

  navigateToCustomer(id) {
    this.router.navigate(['customerdetails', id])
  }
}

