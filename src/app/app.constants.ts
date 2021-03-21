import { HttpHeaders } from "@angular/common/http";


// export const apiUrl = "http://shree.streeft.com/ShreeBackend/index.php/API/";
// export const imgUrl = "http://shree.streeft.com/ShreeBackend/";
export const apiUrl = "http://localhost/ShreeBackend/index.php/API/";
export const imgUrl = "http://localhost/ShreeBackend/uploads/";
// export const idproof = [{
//     "name": "Pancard",
//     "value": "pancard",
//     "pattern": "^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$"
// },
// {
//     "name": "Aadhar card",
//     "value": "aadharcard",
//     "pattern": "^\d{4}\s\d{4}\s\d{4}$"
// },
// {
//     "name": "Driving License",
//     "value": "drivinglicense",
//     "pattern": "^[0-9a-zA-Z]{4,9}$"
// },
// {
//     "name": "Voting Card",
//     "value": "votingcard",
//     "pattern": "^([a-zA-Z]){3}([0-9]){7}?$"
// },
// {
//     "name": "Company/College Id",
//     "value": "company/college",
//     "pattern": ""
// }]

export const httpOptionsGet = {
    headers: new HttpHeaders({
        Accept: "application/json, text/plain, */*"
    }),
    withCredentials: true
};

export const httpOptionsPost = {
    headers: new HttpHeaders({
        Accept: "application/json",
        "Content-Type": "text/plain;charset=UTF-8"
    }),
    withCredentials: true
};

export const httpOptionsAdmin = {
    headers: new HttpHeaders({}),
    withCredentials: true
};

export const httpOptionsGetVideo = {
    headers: new HttpHeaders({
        Accept: "application/json, text/plain, */*",
        "Access-Control-Allow-Origin": "*",
        "X-Frame-Options": "allow"
    }),
    withCredentials: true
};
