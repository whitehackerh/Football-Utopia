import axios from 'axios';
const apiUrl = "http://127.0.0.1:80/api";
export const requestHeaders = {
    "Content-type": "application/json",
    "Authorization": '',
}
export const noTokenRequest = axios.create({
    baseURL:apiUrl,
    headers:{"Content-type":"application/json"}
})
export const withTokenRequest = axios.create({
    baseURL:apiUrl,
})