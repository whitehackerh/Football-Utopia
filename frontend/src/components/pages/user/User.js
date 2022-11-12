import { useLocation } from 'react-router-dom';
import { useEffect } from 'react';
import { withTokenRequest, requestHeaders } from '../../../http';

const User = () => {
  const location = useLocation();
  const userToken = {
    token: location.state.access_token,
    token_type: location.state.token_type
  };
  requestHeaders.Authorization = `Bearer ${userToken.token}`;
  useEffect(() => {
    withTokenRequest.get('/getAccount', {
        headers: requestHeaders
    })
    .then((res) => {
        console.log(res.data);
    })
    .catch((error) => {
        console.log(error);
    });
  })
    return (
        <div style={{ padding: "1rem 0" }}>
            <h2>User</h2>
        </div>
    );
};

export default User;