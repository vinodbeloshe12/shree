import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { UserService } from '../service/user.service';
import { idproof, imgUrl } from '../app.constants';
import { FileSaverService } from 'ngx-filesaver';
import { FileSaverOptions } from 'file-saver';
import { HttpClient } from '@angular/common/http';
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
  photoIdSave: boolean = false;
  emailValidate: boolean;
  id = idproof;
  imageURL = imgUrl;
  idproofData: any = [];
  selectedId: any = {};
  imageName: any = [];
  profileImage: any = [];
  imgPop: boolean = false;
  buttonLabel: string = "Update";
  url = "https://www.pngitem.com/pimgs/m/80-800194_transparent-users-icon-png-flat-user-icon-png.png";
  options: FileSaverOptions = {
    autoBom: false,
  };

  constructor(private activatedRoute: ActivatedRoute, private router: Router, private userService: UserService,
    private httpClient: HttpClient,
    private fileSaverService: FileSaverService,) { }

  ngOnInit() {

    if (this.activatedRoute.snapshot.params.id == 'add') {
      this.customerData = {};
      this.customerData.details = {};
      this.buttonLabel = "Save";
    } else {
      this.getUserDetails(this.activatedRoute.snapshot.params.id);
    }
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
    this.transactionFormData = {};
    this.transactionFormData.purchase_date = new Date();
  }


  createUser(data) {
    this.userService.createUser(data).subscribe((res: any) => {
      alert("user saved");
      console.log("response", res);
      this.customerData = {};
      this.router.navigate(['customerdetails', res.userId]);
      this.getUserDetails(res.userId);
    }, err => console.log(err));
  }
  updateUser(data) {
    console.log("data", data);
    this.userService.updateUser(data).subscribe((res: any) => {
      this.getUserDetails(this.activatedRoute.snapshot.params.id);
      alert("user data updated");
    }, err => console.log(err));
  }

  getMobileDetailsByImei(id) {
    this.userService.getMobileDetailsByImei(id).subscribe((res: any) => {
      this.transactionFormData = res.data;
      this.transactionFormData.price = "";
      this.transactionFormData.purchase_date = new Date();
      // alert("mobile data found");
    }, err => console.log(err));
  }

  deleteIdProofImage(data) {
    this.userService.deleteIdProofImage(data).subscribe((res: any) => {
      console.log("res", data)
      this.getUserDetails(this.activatedRoute.snapshot.params.id);
    }, err => console.log(err));
  }



  selectId(sid) {
    let findex = this.id.findIndex(i => i.value == sid);
    if (findex != -1) {
      this.selectedId = this.id[findex];
      console.log("this.selectedId", this.selectedId)
    }
  }

  sameAddress(value) {
    if (value) {
      if (this.customerData.details && this.customerData.details.current_address) {
        this.customerData.details.permanent_address = this.customerData.details.current_address;
      }
    }
    else {
      this.customerData.details.permanent_address = "";
    }
  }

  onProfileChange(fileInput: any) {
    this.profileImage = [];
    let files = fileInput.srcElement.files;
    console.log("files", files)
    for (let i = 0; i < files.length; i++) {
      var reader = new FileReader();
      reader.onload = (event: ProgressEvent) => {
        this.profileImage.push((<FileReader>event.target).result);
      }
      reader.readAsDataURL(fileInput.srcElement.files[i]);
    }
    this.updateUserProfile(files[0]);
    this.customerData.details.image = files[0]['name'];
  }

  updateUserProfile(file) {
    let data = {
      id: this.activatedRoute.snapshot.params.id,
      image: file
    }
    this.userService.updateUserProfile(data).subscribe((res: any) => {
      if (res.value) {
        console.log("profile image updated")
      }
    });
  }

  onFileChange(fileInput: any) {
    this.imageName = [];
    let files = fileInput.srcElement.files;
    console.log("in files", files)
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

  openImgModal() {
    this.imgPop = true;
  }

  closeImgModal() {
    this.imgPop = false;
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

  addTransaction(data) {
    data.cust_id = this.activatedRoute.snapshot.params.id;
    console.log(data, "transaction data");
    this.userService.createTransaction(data).subscribe((res: any) => {
      alert("Transaction added");
      this.transactionPop = false;
      this.getUserDetails(this.activatedRoute.snapshot.params.id);
      this.transactionFormData = {};
    }, err => console.log(err));

  }


  getTransactionDetails(id) {
    this.transactionPop = true;
    this.userService.getTransactionDetails(id).subscribe((res: any) => {
      this.transactionFormData = res.data;
      console.log("id", this.transactionFormData);

    }, err => console.log(err));
  }


  downloadImage(url, fileName) {
    this.httpClient.get('https://cors-anywhere.herokuapp.com/' + url, {
      observe: 'response',
      responseType: 'blob'
    }).subscribe(res => {
      this.fileSaverService.save(res.body, fileName);
    });
  };
}
