import { Component, OnInit } from '@angular/core';
import { trigger, style, animate, transition } from "@angular/animations";
import { UserService } from '../service/user.service';
import { idproof } from '../app.constants';


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
  emailValidate: boolean;
  id = idproof;
  idproof = {};
  idproofData: any = [];
  selectedId = {};
  imageName: any = [];
  image;

  constructor(private userService: UserService) { }

  ngOnInit() {
    this.getAllCustomers();
  }


  toggleDisplay() {
    this.isShow = !this.isShow;
    this.isDisabled = false;
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

  getIdProofDetails(id) {
    this.userService.getIdProofDetails(id).subscribe((res: any) => {
      if (res.value) {
        this.idproofData = res.data;
      }
    }, err => console.log(err));

  }

  registerUser(data) {
    this.userService.createUser(data).subscribe((res: any) => {
      if (res.value) {
        this.isDisabled = false;
      } else {
        alert(res.message);
      }
    })
  }


  onlyNumbers(event: any) {
    const pattern = /[0-9\+\-\ ]/;
    let inputChar = String.fromCharCode(event.charCode);
    // console.log(inputChar, e.charCode);
    if (!pattern.test(inputChar)) {
      // invalid character, prevent input
      event.preventDefault();
    }
  }


  validateEmail(email) {
    if (email) {
      let reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
      if (reg.test(email) == false) {
        this.emailValidate = true;
        return false;
      }
      else {
        this.emailValidate = false;
      }
    }
  }

  selectId(sid) {
    let findex = this.id.findIndex(i => i.value == sid);
    if (findex != -1) {
      this.selectedId = this.id[findex];
      console.log("this.selectedId", this.selectedId)
    }
  }

  onFileChange(fileInput: any) {
    this.imageName = [];
    let files = fileInput.srcElement.files;
    for (let i = 0; i < files.length; i++) {
      this.imageName.push(files[i]);
    }
    this.image = files;
  }
}

