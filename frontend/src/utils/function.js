import { withTokenRequest, requestHeaders } from '../http';

export function getUserBasicProfile() {
    requestHeaders.Authorization = `${localStorage.getItem('token_type')} ${localStorage.getItem('access_token')}`;
    withTokenRequest.get('/getUserBasicProfile', {
        headers: requestHeaders
    }).then((res) => {
        localStorage.setItem('user_id', res.data.id);
    });
};
