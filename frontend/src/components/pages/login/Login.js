import * as React from "react";
import TextField from "@mui/material/TextField";
import Button from "@mui/material/Button";
import { Link } from "react-router-dom";

const Login = () => {
  // ページ遷移用に作ったコンポーネント
  return (
    <div style={{ padding: "1rem 0" }}>
      <h2>Login</h2>
      <TextField id="outlined-basic" label="User Name" variant="outlined" />
      <TextField id="outlined-basic" label="Password" variant="outlined" />
      <Button variant="contained" style={{ margin: "10px" }}>
        login
      </Button>
      <Link to="/Signup">Signup</Link>  
    </div>
  );
};

export default Login;