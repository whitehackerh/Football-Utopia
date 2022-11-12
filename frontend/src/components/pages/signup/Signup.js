import { noTokenRequest } from '../../../http';
import { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import TextField from "@mui/material/TextField";
import Button from "@mui/material/Button";

export default function Signup() {
    const navigate = useNavigate();
    const [values, setValues] = useState({
        user_name: '',
        name: '',
        email: '',
        password: ''
    });
    
    function handleChange(e) {
        const target = e.target;
        const value = target.value;
        const name = target.name;
        setValues({ ...values, [name]: value });
    }

    function registerUser() {    
        noTokenRequest.post('/register', {
            user_name: values.user_name, 
            name: values.name, 
            email: values.email, 
            password: values.password
        })
        .then((res) => {
            console.log(res);
            navigate('/User', {state: res.data});
        })
        .catch((error) => {
            console.log(error);
        });
    }
    
    const registerUserForm = {
        margin: "50px",
    }

    return (
        <div style={registerUserForm}>
            <h2>Signup</h2>
            <TextField id="outlined-basic" label="User Name" variant="outlined" name="user_name" value={values.user_name} onChange={handleChange}/><br /><br />
            <TextField id="outlined-basic" label="Name" variant="outlined" name="name" value={values.name} onChange={handleChange}/><br /><br />
            <TextField id="outlined-basic" label="Email" variant="outlined" name="email" value={values.email} onChange={handleChange}/><br /><br />
            <TextField id="outlined-basic" label="Password" variant="outlined" name="password" value={values.password} onChange={handleChange}/><br /><br /><br />
            <Button variant="contained" style={{ margin: "10px" }} onClick={registerUser}>Register</Button>
        </div>
    );

}