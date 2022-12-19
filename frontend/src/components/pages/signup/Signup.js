import { noTokenRequest } from '../../../http';
import { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import TextField from "@mui/material/TextField";
import Button from "@mui/material/Button";
import Select from "@mui/material/Select";
import { MenuItem } from '@mui/material';
import InputLabel from "@mui/material/InputLabel";

export default function Signup() {
    const navigate = useNavigate();
    const [values, setValues] = useState({
        user_name: '',
        name: '',
        email: '',
        password: '',
        age: '',
        gender: ''
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
            password: values.password,
            age: values.age,
            gender: values.gender
        })
        .then((res) => {
            localStorage.setItem('access_token', res.data.access_token);
            localStorage.setItem('token_type', res.data.token_type);
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
            <TextField id="outlined-basic" label="Password" variant="outlined" name="password" value={values.password} onChange={handleChange}/><br /><br />
            <TextField id="outlined-basic" label="Age" variant="outlined" name="age" value={values.age} onChange={handleChange}/><br /><br />
            <InputLabel id="gender-select-label">Gender</InputLabel>
            <Select style={{width: "120px"}} labelId="gender-select-label" id="outlined-basic" label="Gender" name="gender" value={values.gender} onChange={handleChange}><MenuItem value="men">men</MenuItem><MenuItem value="women">women</MenuItem></Select><br /><br /><br />
            <Button variant="contained" style={{ margin: "10px" }} onClick={registerUser}>Register</Button>
        </div>
    );
}
