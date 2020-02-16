import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { apiUrl, httpOptionsPost, httpOptionsGet, idproof } from '../app.constants';

@Injectable({
  providedIn: 'root'
})
export class UserService {
  constructor(private http: HttpClient) { }

  getAllCustomers() {
    return this.http.get(apiUrl + "getAllUsers", httpOptionsGet);
  }

  createUser(data) {
    return this.http.post(apiUrl + "registerUser", JSON.stringify(data), httpOptionsPost);
  }
}
