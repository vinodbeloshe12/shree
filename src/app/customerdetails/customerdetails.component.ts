import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { UserService } from '../service/user.service';
import { idproof } from '../app.constants';

@Component({
  selector: 'app-customerdetails',
  templateUrl: './customerdetails.component.html',
  styleUrls: ['./customerdetails.component.less']
})
export class CustomerdetailsComponent implements OnInit {
  customerData: any = {};
  contactFormData: any = {};
  idprooFormData: any = {};
  transactionFormData: any = {};
  addKYC: boolean = false;
  transactionPop: boolean = false;
  addContacts: boolean = false;
  emailValidate: boolean;
  id = idproof;
  idproofData: any = [];
  selectedId: any = {};
  imageName: any = [];

  constructor(private activatedRoute: ActivatedRoute, private userService: UserService) { }

  ngOnInit() {
    this.getUserDetails(this.activatedRoute.snapshot.params.id);
  }

  getUserDetails(id) {
    this.userService.getUserDetailsById(id).subscribe((res: any) => {
      if (res.value) {
        this.customerData = res;
        console.log("customerData", this.customerData);
      }
    }, err => console.log(err));
  }
  newTransaction() {
    this.transactionPop = !this.transactionPop;
  }

  updateUser(data) {
    this.userService.updateUser(data).subscribe((res: any) => {
      this.getUserDetails(this.activatedRoute.snapshot.params.id);
      alert("user data updated");
    }, err => console.log(err));
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
    console.log("files", files)
    for (let i = 0; i < files.length; i++) {
      var reader = new FileReader();
      reader.onload = (event: ProgressEvent) => {
        this.imageName.push((<FileReader>event.target).result);
      }
      reader.readAsDataURL(fileInput.srcElement.files[i]);
    }
    this.idprooFormData.images = files;
  }


  submitKYC(data) {
    data.cust_id = this.activatedRoute.snapshot.params.id;
    this.userService.createIdproof(data).subscribe((res: any) => {
      this.addKYC = false;
      this.getUserDetails(this.activatedRoute.snapshot.params.id);
      this.idprooFormData = {};
      this.imageName = [];
    }, err => console.log(err));
  }

  removeIdProof(id, type, custid) {
  }


  submitContact(data) {
    data.cust_id = this.activatedRoute.snapshot.params.id;
    this.userService.createContact(data).subscribe((res: any) => {
      this.addContacts = false;
      this.getUserDetails(this.activatedRoute.snapshot.params.id);
      this.contactFormData = {};
      alert("new contact added");
    }, err => console.log(err));
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

}
