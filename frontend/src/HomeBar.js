import { useNavigate } from "react-router-dom";
import { useState } from 'react';
import { withTokenRequest, requestHeaders } from './http';
import { Box } from "@mui/material";
import Logo from "./assets/img/logo.png"
import AppBar from "@mui/material/AppBar";
import Toolbar from "@mui/material/Toolbar";
import Typography from "@mui/material/Typography";
import Button from "@mui/material/Button";
import IconButton from "@mui/material/IconButton";
import MenuItem from "@mui/material/MenuItem";
import Menu from "@mui/material/Menu";
import AccountCircleIcon from '@mui/icons-material/AccountCircle';

const HomeBar = () => {
  let navigate = useNavigate();

  const [anchorEl, setAnchorEl] = useState(null);
  const isMenuOpen = Boolean(anchorEl);
  const handleProfileMenuOpen = (event) => {
    setAnchorEl(event.currentTarget);
  }
  const handleMenuClose = () => {
    setAnchorEl(null);
  };
  const renderMenu = () => {
    return (
      <Menu
        anchorEl={anchorEl}
        anchorOrigin={{ vertical: "top", horizontal: "right" }}
        transformOrigin={{ vertical: "top", horizontal: "right" }}
        open={isMenuOpen}
        onClose={handleMenuClose}
      >
        <MenuItem onClick={() => {handleMenuClose(); navigate("/basicProfileSettings");}}>Account Settings</MenuItem>
        <MenuItem onClick={() => {handleMenuClose(); LogoutEvent();}}>Logout</MenuItem>
      </Menu>
    );
  };

  const LogoutEvent = () => {
    requestHeaders.Authorization = `${localStorage.getItem('token_type')} ${localStorage.getItem('access_token')}`;
    withTokenRequest.get('/logout', {
      headers: requestHeaders
    }).then(() => {
      localStorage.removeItem('access_token');
      localStorage.removeItem('token_type');
      localStorage.removeItem('user_id');
      navigate('/');
    })
  }

  var AuthMenu = '';
  if (localStorage.getItem('access_token')) {
    AuthMenu = (
      <>
      <IconButton 
      aria-owns={isMenuOpen ? "material-appbar" : undefined}
      aria-haspopup="true"
      onClick={handleProfileMenuOpen}
      color="inherit">
          <AccountCircleIcon />
      </IconButton>
      </>
    );
  } else {
    AuthMenu = (
    <Button color="inherit" onClick={() => navigate('/login')}>
      Login
    </Button>
    );
  }

  return (
    <Box>
      {/* <AppBar position="static" style={{"background-color": "transparent"}}> */}
      <AppBar position="static" style={{background: "#00ff00"}}>
        <Toolbar>
          <Typography variant="h6" component="div" sx={{ flexGrow: 1 }}>
            <img src={Logo} alt="picture" onClick={() => navigate('/')} style={{cursor: "pointer"}}/>
          </Typography>
          {AuthMenu}
        </Toolbar>
      </AppBar>
      {renderMenu()}
    </Box>
  );
};

export default HomeBar;