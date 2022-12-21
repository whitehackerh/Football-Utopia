import { useNavigate } from "react-router-dom";
import { useState } from 'react';
import { withTokenRequest, requestHeaders } from './http';
import { Box } from "@mui/material";
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
        <MenuItem onClick={() => {handleMenuClose(); goToAccountSettingsPage();}}>Account Settings</MenuItem>
        <MenuItem onClick={() => {handleMenuClose(); LogoutEvent();}}>Logout</MenuItem>
      </Menu>
    );
  };

  const goToAccountSettingsPage = () => {
    navigate("/accountSettings");
  }
  const goToLoginPage = () => {
    // ボタンクリックによるページ遷移
    navigate("/login");
  };

  const LogoutEvent = () => {
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
    <Button color="inherit" onClick={() => goToLoginPage()}>
      Login
    </Button>
    );
  }

  return (
    <Box>
      <AppBar position="static">
        <Toolbar>
          <Typography variant="h6" component="div" sx={{ flexGrow: 1 }}>
            News
          </Typography>
          {AuthMenu}
        </Toolbar>
      </AppBar>
      {renderMenu()}
    </Box>
  );
};

export default HomeBar;