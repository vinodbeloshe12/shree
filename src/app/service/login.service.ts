import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { apiUrl, httpOptionsPost, httpOptionsGet } from '../app.constants';


@Injectable({
  providedIn: 'root'
})
export class LoginService {

  constructor(private http: HttpClient) { }

  login(data) {
    return this.http.post(apiUrl + "login", JSON.stringify(data), httpOptionsPost);
  }
}
