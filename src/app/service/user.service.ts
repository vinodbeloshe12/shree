import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { apiUrl, httpOptionsPost, httpOptionsGet, httpOptionsAdmin } from '../app.constants';

@Injectable({
  providedIn: 'root'
})
export class UserService {
  constructor(private http: HttpClient) { }

  getAllCustomers() {
    return this.http.get(apiUrl + "getAllUsers", httpOptionsGet);
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
  createTransaction(data) {
    return this.http.post(apiUrl + "createTransaction", JSON.stringify(data), httpOptionsPost);
  }
  updateUser(data) {
    return this.http.post(apiUrl + "updateUser", JSON.stringify(data), httpOptionsPost);
  }
}
