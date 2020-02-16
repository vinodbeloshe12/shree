import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-customerdetails',
  templateUrl: './customerdetails.component.html',
  styleUrls: ['./customerdetails.component.less']
})
export class CustomerdetailsComponent implements OnInit {

  constructor() { }

  ngOnInit() {
  }
  transactionPop = false;

  newTransaction() {
    this.transactionPop = !this.transactionPop;
  }

}
