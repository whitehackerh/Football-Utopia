import { withTokenRequest, requestHeaders } from '../http';

export function getUserBasicProfile() {
    requestHeaders.Authorization = `${localStorage.getItem('token_type')} ${localStorage.getItem('access_token')}`;
    withTokenRequest.get('/getUserBasicProfile', {
        headers: requestHeaders
    }).then((res) => {
        localStorage.setItem('user_id', res.data.id);
    });
};

export function deleteBackSlash(value) {
    return value.replace(/(\\)/g, '');
}

export function getCookieArray() {
    var arr = new Array();
    if(document.cookie != ''){
        var tmp = document.cookie.split('; ');
        for(var i=0;i<tmp.length;i++){
        var data = tmp[i].split('=');
        arr[data[0]] = decodeURIComponent(data[1]);
        }
    }
    return arr;
}

export function getCookieArrayValue(cookie) {
    cookie = cookie.replace('[', '');
    cookie = cookie.replace(']', '');
    return cookie;
}

export function getCookieArrayFirstValue(cookie) {
    const indexOfComma = cookie.indexOf(',');
    if (indexOfComma == -1) {
        return cookie;
    }
    let firstValue = '';
    for (let i = 0; i < indexOfComma; i++) {
        firstValue += cookie[i];
    }
    return firstValue;
}

export function deleteCookieArrayFirstValue(cookie) {
    const indexOfComma = cookie.indexOf(',');
    if (indexOfComma == -1) {
        return indexOfComma;
    }
    cookie = cookie.slice(indexOfComma + 1);
    return cookie;
}

export function makeCookieArray(cookie) {
    return '[' + cookie + ']';
}