import { useNavigate } from "react-router-dom";
import { withTokenRequest, requestHeaders } from './http';
import AppBar from "@mui/material/AppBar";
import Toolbar from "@mui/material/Toolbar";
import Typography from "@mui/material/Typography";
import Button from "@mui/material/Button";

const HomeBar = () => {
  let navigate = useNavigate();
  const goToAccountPage = () => {
    // ボタンクリックによるページ遷移
    navigate("/login");
  };
  const LogoutEvent = (e) => {
    e.preventDefault();
    requestHeaders.Authorization = `${localStorage.getItem('token_type')} ${localStorage.getItem('access_token')}`;
    withTokenRequest.get('/logout', {
      headers: requestHeaders
    }).then(() => {
      localStorage.removeItem('access_token');
      localStorage.removeItem('token_type');
      navigate('/');
    })
  }

  var AuthMenu = '';
  if (localStorage.getItem('access_token')) {
    AuthMenu = (
    <Button color="inherit" onClick={LogoutEvent}>
      Logout
    </Button>
    );
  } else {
    AuthMenu = (
    <Button color="inherit" onClick={() => goToAccountPage()}>
      Login
    </Button>)
  }
  

  return (
    <AppBar position="static">
      <Toolbar>
        <Typography variant="h6" component="div" sx={{ flexGrow: 1 }}>
          News
        </Typography>
        {AuthMenu}
      </Toolbar>
    </AppBar>
  );
};

export default HomeBar;