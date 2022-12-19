import { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { noTokenRequest } from '../../../http';
import TextField from "@mui/material/TextField";
import Button from "@mui/material/Button";
import { Link } from "react-router-dom";

const Login = () => {
  const navigate = useNavigate();
  const [values, setValues] = useState({
    user_name: '',
    password: ''
  });

  function handleChange(e) {
    const target = e.target;
    const value = target.value;
    const name = target.name;
    setValues({ ...values, [name]: value });
  }

  function loginOperation() {
    noTokenRequest.post('/login', {
      user_name: values.user_name,
      password: values.password
    })
    .then((res) => {
      localStorage.setItem('access_token', res.data.access_token);
      localStorage.setItem('token_type', res.data.token_type);
      navigate('/User', {state: res.data});
    })
    .catch((error) => {
      console.log(error);
    })
  }

  const loginForm = {
    margin: "50px"
  }

  return (
    <div style={loginForm}>
      <TextField id="outlined-basic" label="User Name" variant="outlined" name="user_name" value={values.user_name} onChange={handleChange} />
      <TextField id="outlined-basic" label="Password" variant="outlined" name="password" value={values.password} onChange={handleChange} />
      <Button variant="contained" style={{ margin: "10px" }} onClick={loginOperation}>
        Login
      </Button>
      <Link to="/Signup">Signup</Link>  
    </div>
  );
};

export default Login;