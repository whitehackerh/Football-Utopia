import { useLocation } from 'react-router-dom';
import { useEffect, useState } from 'react';
import { withTokenRequest, requestHeaders } from '../../../http';
import TextField from "@mui/material/TextField";
import Button from "@mui/material/Button";

const User = () => {
  const location = useLocation();
  const userToken = {
    token: location.state.access_token,
    token_type: location.state.token_type
  };
  const [values, setValues] = useState(null);
  const [errorVisibleFlag, setErrorVisibleFlag] = useState(false);
  requestHeaders.Authorization = `${userToken.token_type} ${userToken.token}`;

  useEffect(() => {
    getAccount();
  }, []);

  const getAccount = async () => {
    const responseParam = await withTokenRequest.get('/getAccount', {
        headers: requestHeaders
    });
    setValues(responseParam.data);
  };

  /**↓ after mounted ↓ */

  function handleChange(e) {
    const target = e.target;
    const value = target.value;
    const name = target.name;
    setValues({ ...values, [name]: value });
  }

  function updateUser() {    
    withTokenRequest.post('/updateUserBasicInfo', {
        user_id: values.id,
        user_name: values.user_name, 
        name: values.name, 
        email: values.email, 
        password: values.password
    }, {
      headers: requestHeaders,
    })
    .then(() => {
      setErrorVisibleFlag(false);
      getAccount();
    })
    .catch((error) => {
        console.log(error);
        setErrorVisibleFlag(true);
        setValues({ ...values, errorMessage: error.response.data.data.errors});
    });
  }

  if (values === null) {
    return (
        <div></div>
    );
  }

  const userForm = {
    margin: "50px"
  }

  const errorMessageStyles = {
    visibility: errorVisibleFlag ? 'visible' : 'hidden',
    padding: "20px 0",
    "font-size": "20px",
    "background-color": "pink",
    margin: "20px 50px",
    color: "red"
  }

  return (
    <div>
      <div>
        <h1 style={errorMessageStyles}>{values.errorMessage}</h1><br></br>
      </div>
      <div style={userForm}>
        <TextField id="outlined-basic" label="User Name" variant="outlined" name="user_name" value={values.user_name} onChange={handleChange}/><br /><br />
        <TextField id="outlined-basic" label="Name" variant="outlined" name="name" value={values.name} onChange={handleChange}/><br /><br />
        <TextField id="outlined-basic" label="Email" variant="outlined" name="email" value={values.email} onChange={handleChange}/><br /><br />
        <Button variant="contained" style={{ margin: "10px" }} onClick={updateUser}>SAVE</Button>
      </div>
    </div>
  );
};

export default User;