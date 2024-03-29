import { Component, OnInit } from '@angular/core';
import { UserService } from '../service/user.service';
import { TagInputModule } from 'ngx-chips';
import { Router } from '@angular/router';

TagInputModule.withDefaults({
  tagInput: {
    placeholder: 'Add New',
    // add here other default values for tag-input
  },
  dropdown: {
    displayBy: 'name',
    // add here other default values for tag-input-dropdown
  }
});
@Component({
  selector: 'app-brandstock',
  templateUrl: './brandstock.component.html',
  styleUrls: ['./brandstock.component.less']
})


export class BrandstockComponent implements OnInit {
  public Brandtab = true;
  public Stocktab = false;
  public Skmodel = false;
  public myDate = Date.now();    //date 
  stock: any = {};
  brand: any = [];
  model: any = [];
  color: any = [];
  price: any = [];
  imei1: any[];
  imei2: any[];
  brands: any = [];
  stockList: any = [];
  models: any = [];
  soldStatus = 0;

  BrandToggle() {
    this.Brandtab = true;
    this.Stocktab = false;
  }
  StockToggle() {
    this.Brandtab = false;
    this.Stocktab = true;
  }
  constructor(private userService: UserService, private router: Router) { }

  ngOnInit() {
    this.getAllBrands();
    this.getAllStock(this.soldStatus);
    this.stock.purchase_date = new Date();
    console.log("stock", this.stock)
  }

  onSelectedBrand(data) {
    console.log("onSelectedBrand", data);
    this.getAllModels(data.id);
  }

  onBrandRemoved(data) {
    console.log("removed", data);
  }
  onBrandAdd(data) {
    console.log("data", data, this.stock.brand);
    if (data.id) {
      this.getAllModels(data.id);
      this.stock.brand = data.id;
    } else {
      this.createBrand(data.value);
    }
  }
  onModelAdd(data) {
    if (data.id) {
      this.stock.model = data.id;
    } else {
      this.createModel(data.value);
    }
    console.log("stock", this.stock)
  }


  getAllBrands() {
    this.userService.getAllBrands().subscribe((res: any) => {
      this.brands = res.data;
      console.log("this.brands", this.brands)
    })
  }

  createBrand(brand) {
    let data = { name: brand };
    this.userService.createBrand(data).subscribe((res: any) => {
      console.log("brand added", res);
      this.stock.brand = res.id;
      this.getAllBrands();
    })
  }
  createModel(model) {
    console.log("moidel", model)
    let data = { name: model, brand: this.stock.brand };
    console.log("in create model", data);
    this.userService.createModel(data).subscribe((res: any) => {
      console.log("model added")
      this.stock.model = res.id;
      this.getAllModels(this.stock.brand);
    })
  }
  getAllModels(brand) {
    console.log("brand", brand)
    this.userService.getAllModels(brand).subscribe((res: any) => {
      this.models = res.data;
      console.log("this.models", this.models)
      this.Skmodel = true;
    })
  }


  addStock(stockData) {
    stockData.brand = this.stock.brand;
    stockData.model = this.stock.model;
    stockData.purchase_date = this.myDate;
    this.userService.createStock(stockData).subscribe((res: any) => {
      if (res.value) {
        alert("Stock added");
        this.stock = {};
        this.brand = [];
        this.model = [];
        this.color = [];
        this.stock.purchase_date = new Date();
        this.price = [];
        this.imei1 = [];
        this.imei2 = [];
        this.getAllStock(this.soldStatus);
      } else {
        alert(res.message);
      }
    })
  }

  getAllStock(soldStatus) {
    this.userService.getAllStock(soldStatus).subscribe((res: any) => {
      this.stockList = res.data;
    })
  }

  modelChanged(value) {
    this.getAllStock(value);
  }

  navigateToCustomer(id) {
    this.router.navigate(['customerdetails', id])
  }
}
