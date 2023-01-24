import { useEffect, useState } from 'react';
import { withTokenRequest, requestHeaders, noTokenRequest } from '../../../http';
import SideBar_AccountSettings from './SideBar_AccountSettings'; 
import TextField from "@mui/material/TextField";
import Button from "@mui/material/Button";
import { Autocomplete } from '@mui/material';
import { years } from '../../modules/const/years';

const BasicProfileSettings = () => {
  const [masterData, setMasterData] = useState(null);
  const [values, setValues] = useState(null);
  const [gender, setGender] = useState(null);
  const [nationality, setNationality] = useState(null);
  //const [errorVisibleFlag, setErrorVisibleFlag] = useState(false);
  requestHeaders.Authorization = `${localStorage.getItem('token_type')} ${localStorage.getItem('access_token')}`;

  useEffect(() => {
    getMasterData();
    getUserBasicProfile();
    getUserBasicProfileWithName();
  }, []);

  function getMasterData() {
    noTokenRequest.get('/getMasterDataForProfile', {
    }).then((res) => {
        setMasterData(res.data.data);
    });
  }

  function getUserBasicProfile() {
    withTokenRequest.get('/getUserBasicProfile', {
        headers: requestHeaders
    }).then((res) => {
      setValues(res.data);
    });
  };

  function getUserBasicProfileWithName() {
    let responseParam2 = null;
    withTokenRequest.post('/getUserBasicProfileWithName', {
      user_id: localStorage.getItem('user_id')
    }, {
      headers: requestHeaders
    }).then((res2) => {
      responseParam2 = res2.data.data;
      setGender({
        ...gender,
        id: responseParam2.gender.id ? responseParam2.gender.id : null,
        name: responseParam2.gender.name? responseParam2.gender.name : '',
      });
      setNationality({
          ...nationality,
          id: responseParam2.nationality.id ? responseParam2.nationality.id : null,
          name: responseParam2.nationality.name? responseParam2.nationality.name : '',
      });
    });
  }

  /**↓ after mounted ↓ */

  function handleChange(e, newValue = null, setterName = null, setterParams = null) {
    const target = e.target;
    let value = target.value;
    const name = target.name;
    switch (setterName) {
      case 'setAge':
        setValues({...values, age: newValue});
        break;
      case 'setGender':
        setGender({
            ...gender,
            id: newValue ? newValue.id : null,
            name: newValue ? newValue.name : ''
        });
        break;
      case 'setNationality':
        setNationality({
            ...nationality,
            id: newValue ? newValue.id : null,
            name: newValue ? newValue.name : ''
        });
        break;
      default:
        setValues({ ...values, [name]: value });
        break;
    }
  }

  function updateUser() {    
    withTokenRequest.post('/setUserBasicProfile', {
        user_id: values.id,
        user_name: values.user_name, 
        name: values.name, 
        email: values.email, 
        password: values.password,
        age: values.age,
        gender: gender.id,
        nationality: nationality.id
    }, {
      headers: requestHeaders,
    })
    .then(() => {
      // setErrorVisibleFlag(false);
      getUserBasicProfile();
    })
    .catch((error) => {
        console.log(error);
        // setErrorVisibleFlag(true);
        // setValues({ ...values, errorMessage: error.response.data.data.errors});
    });
  }

  if (values === null || masterData === null || gender == null || nationality == null) {
    return (
        <div></div>
    );
  }

  /** css */

  const mainContents = {
    float: 'left',
    margin: '10px',
    width: 'calc(100% - 362px)'
  }

  const userForm = {
    margin: "50px"
  }

  // const errorMessageStyles = {
  //   visibility: errorVisibleFlag ? 'visible' : 'hidden',
  //   padding: "20px 0",
  //   "font-size": "20px",
  //   "background-color": "pink",
  //   margin: "20px 50px",
  //   color: "red"
  // }

  return (
    <div>
        <SideBar_AccountSettings />
        <div style={mainContents}>
          <div>
            {/* <h1 style={errorMessageStyles}>{values.errorMessage}</h1><br></br> */}
          </div>
          <div style={userForm}>
            <TextField id="outlined-basic" label="User Name" variant="outlined" name="user_name" value={values.user_name} onChange={handleChange}/><br /><br />
            <TextField id="outlined-basic" label="Name" variant="outlined" name="name" value={values.name} onChange={handleChange}/><br /><br />
            <TextField id="outlined-basic" label="Email" variant="outlined" name="email" value={values.email} onChange={handleChange}/><br /><br />
            <Autocomplete
              id="age"
              options={years}
              value={values.age}
              sx={{ width: 120 }}
              renderInput={(params) => <TextField {...params} label="Age" />}
              onChange={(e, newValue) => handleChange(e, newValue, 'setAge')}
            >                    
            </Autocomplete><br></br>
            <Autocomplete options={masterData.gender} getOptionLabel={(option) => option.name} defaultValue={gender ? gender : ''}sx={{ width: 240 }} renderInput={(params => <TextField {...params} label="Gender" />)} onChange={(event, newValue) => {handleChange(event, newValue, 'setGender');}} ></Autocomplete><br /><br />
            <Autocomplete options={masterData.nations} getOptionLabel={(option) => option.name} defaultValue={nationality ? nationality : ''} sx={{ width: 240 }} renderInput={(params => <TextField {...params} label="Nationality" />)} onChange={(event, newValue) => {handleChange(event, newValue, 'setNationality');}} ></Autocomplete><br /><br />
            <Button variant="contained" style={{ margin: "10px" }} onClick={updateUser}>SAVE</Button>
          </div>
        </div>
    </div>
  );
};

export default BasicProfileSettings;