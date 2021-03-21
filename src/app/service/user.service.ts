import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { apiUrl, httpOptionsPost, httpOptionsGet, httpOptionsAdmin } from '../app.constants';

@Injectable({
  providedIn: 'root'
})
export class UserService {
  constructor(private http: HttpClient) { }

  // getAllCustomers() {
  //   return this.http.get(apiUrl + "getAllUsers", httpOptionsGet);
  // }

  getAllBrands() {
    return this.http.get(apiUrl + "getAllBrands", httpOptionsGet);
  }
  getAllModels(brand) {
    return this.http.get(apiUrl + "getAllModels?brand=" + brand, httpOptionsGet);
  }
  getAllStock(soldStatus) {
    return this.http.get(apiUrl + "getAllStock?status=" + soldStatus, httpOptionsGet);
  }
  getAllSales() {
    return this.http.get(apiUrl + "getAllSales", httpOptionsGet);
  }
  getAllUserData() {
    return this.http.get(apiUrl + "getAllUserData", httpOptionsGet);
  }

  getUserDetailsById(id) {
    return this.http.get(apiUrl + "getUserDetailsById?id=" + id, httpOptionsGet);
  }

  getIdProofDetails(id) {
    return this.http.get(apiUrl + "getIdProofDetails?id=" + id, httpOptionsGet);
  }

  createUser(data) {
    return this.http.post(apiUrl + "registerUser", JSON.stringify(data), httpOptionsPost);
  }
  createBrand(data) {
    return this.http.post(apiUrl + "createBrand", JSON.stringify(data), httpOptionsPost);
  }
  createID(data) {
    return this.http.post(apiUrl + "createID", JSON.stringify(data), httpOptionsPost);
  }
  createModel(data) {
    return this.http.post(apiUrl + "createModel", JSON.stringify(data), httpOptionsPost);
  }
  createStock(data) {
    return this.http.post(apiUrl + "createStock", JSON.stringify(data), httpOptionsPost);
  }
  deleteIdProofImage(data) {
    return this.http.post(apiUrl + "deleteIdProofImage", JSON.stringify(data), httpOptionsPost);
  }

  updateUserProfile(data) {
    let body = new FormData();
    body.append('id', data.id);
    body.append("image", data.image, data.image['name']);
    return this.http.post(apiUrl + "updateUserProfile", body, httpOptionsAdmin);
  }

  createIdproof(data) {
    let body = new FormData();
    if (data.id) {
      body.append('id', data.id);
    }
    body.append('name', data.name);
    body.append('cust_id', data.cust_id);
    body.append('number', data.number);
    for (let i = 0; i < data.images.length; i++) {
      body.append("image_name[]", data.images[i], data.images[i]['name']);
    }

    return this.http.post(apiUrl + "createIdProof", body, httpOptionsAdmin);
  }

  createContact(data) {
    return this.http.post(apiUrl + "createContact", JSON.stringify(data), httpOptionsPost);
  }
  getEMIDetails(data) {
    return this.http.post(apiUrl + "getEMIDetails", JSON.stringify(data), httpOptionsPost);
  }
  getChartData(data) {
    return this.http.post(apiUrl + "getChartData", JSON.stringify(data), httpOptionsPost);
  }
  createTransaction(data) {
    return this.http.post(apiUrl + "createTransaction", JSON.stringify(data), httpOptionsPost);
  }
  updateUser(data) {
    return this.http.post(apiUrl + "updateUser", JSON.stringify(data), httpOptionsPost);
  }


  getTransactionDetails(id) {
    return this.http.get(apiUrl + "getTransactionDetails?id=" + id, httpOptionsGet);
  }
  getIds() {
    return this.http.get(apiUrl + "getIds", httpOptionsGet);
  }
  logout() {
    return this.http.get(apiUrl + "logout", httpOptionsGet);
  }
  getUserDetails() {
    return this.http.get(apiUrl + "getUserDetails", httpOptionsGet);
  }
  getMobileDetailsByImei(id) {
    return this.http.get(apiUrl + "getMobileDetailsByImei?id=" + id, httpOptionsGet);
  }
  getDashboardDetails() {
    return this.http.get(apiUrl + "getDashboardDetails", httpOptionsGet);
  }
}
