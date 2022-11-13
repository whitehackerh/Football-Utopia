import { useLocation } from 'react-router-dom';
import { useEffect, useState } from 'react';
import { withTokenRequest, requestHeaders } from '../../../http';

const User = () => {
  const location = useLocation();
  const userToken = {
    token: location.state.access_token,
    token_type: location.state.token_type
  };
  const [response, setResponse] = useState(null);
  requestHeaders.Authorization = `${userToken.token_type} ${userToken.token}`;
  
  useEffect(() => {
    getAccount();
  }, []);

  const getAccount = async () => {
    const responseParam = await withTokenRequest.get('/getAccount', {
        headers: requestHeaders
    });
    setResponse(responseParam.data);
  };

  if (response === null) {
    return (
        <div></div>
    );
  }
  return (
    <div style={{ padding: "1rem 0" }}>
        <h2>{response.user_name}</h2>
    </div>
  );
};

export default User;