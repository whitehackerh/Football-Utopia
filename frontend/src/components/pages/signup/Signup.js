import { noTokenRequest } from '../../../http';
import { getUserBasicProfile } from '../../../utils/function';
import { useEffect, useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { years } from '../../modules/const/years'; 
import TextField from "@mui/material/TextField";
import Button from "@mui/material/Button";
import { Autocomplete } from '@mui/material';

export default function Signup() {
    const navigate = useNavigate();
    const [masterData, setMasterData] = useState(null);
    const [values, setValues] = useState({
        user_name: '',
        name: '',
        email: '',
        password: '',
        age: '',
    });
    const [gender, setGender] = useState({id: null, name: ''});
    const [nationality, setNationality] = useState({id: null, name: ''});

    useEffect(() => {
        getMasterData();
    }, []);

    function getMasterData() {
        noTokenRequest.get('/getMasterDataForProfile', {
        }).then((res) => {
            setMasterData(res.data.data);
        });
    }
    
    function handleChange(e, newValue) {
        const target = e.target;
        let value = target.value;
        const name = target.name;
        if (newValue != null) {
            setValues({...values, age: newValue});
            return;
        }
        setValues({ ...values, [name]: value });
    }

    function registerUser() {    
        noTokenRequest.post('/register', {
            user_name: values.user_name, 
            name: values.name, 
            email: values.email, 
            password: values.password,
            age: values.age,
            gender: gender.id,
            nationality: nationality.id
        })
        .then((res) => {
            localStorage.setItem('access_token', res.data.access_token);
            localStorage.setItem('token_type', res.data.token_type);
            getUserBasicProfile();
            navigate('/basicProfileSettings');
        })
        .catch((error) => {
            console.log(error);
        });
    }
    
    if (masterData == null) {
        return (
            <div></div>
        );
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
            <Autocomplete
                id="age"
                options={years}
                value={values.age}
                sx={{ width: 120 }}
                renderInput={(params) => <TextField {...params} label="Age" />}
                onChange={(e, newValue) => handleChange(e, newValue)}
            >                        
            </Autocomplete><br /><br />
            <Autocomplete options={masterData.gender} getOptionLabel={(option) => option.name} sx={{ width: 240 }} renderInput={(params => <TextField {...params} label="Gender" />)} onChange={(event, newValue) => {setGender({ ...gender, id: newValue ? newValue.id : null, name: newValue ? newValue.name : '' });}} ></Autocomplete><br /><br />
            <Autocomplete options={masterData.nations} getOptionLabel={(option) => option.name} sx={{ width: 240 }} renderInput={(params => <TextField {...params} label="Nationality" />)} onChange={(event, newValue) => {setNationality({ ...nationality, id: newValue ? newValue.id : null, name: newValue ? newValue.name : '' });}} ></Autocomplete><br /><br />
            <Button variant="contained" style={{ margin: "10px" }} onClick={registerUser}>Register</Button>
        </div>
    );
}
