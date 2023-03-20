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
import Badge from '@mui/material/Badge';
import AccountCircleIcon from '@mui/icons-material/AccountCircle';
import notice from './assets/img/icons/notice.png';
import match from './assets/img/icons/match.png';
import message from './assets/img/icons/message.png';
import album from './assets/img/icons/album.png';
import useInterval from 'use-interval';

const HomeBar = () => {
  let navigate = useNavigate();
  const [anchorEl, setAnchorEl] = useState(null);
  const [unreadNotificationsCount, setUnreadNotificationsCount] = useState(0);
  const [unreadMessagesCount, setUnreadMessagesCount] = useState(0);
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
  };

  useInterval(() => {
    if (localStorage.getItem('access_token')) {
      requestHeaders.Authorization = `${localStorage.getItem('token_type')} ${localStorage.getItem('access_token')}`;
      withTokenRequest.post('/getUnreadNotifications', {
        user_id: localStorage.getItem('user_id'),
      }, {
        headers: requestHeaders
      }).then((res) => {
        setUnreadNotificationsCount(res.data.data.unread_count);
      });
    }
  }, 5000);

  useInterval(() => {
    if (localStorage.getItem('access_token')) {
      requestHeaders.Authorization = `${localStorage.getItem('token_type')} ${localStorage.getItem('access_token')}`;
      withTokenRequest.post('/getUnreadMessages', {
        user_id: localStorage.getItem('user_id'),
      }, {
        headers: requestHeaders
      }).then((res) => {
        setUnreadMessagesCount(res.data.data.unread_count);
      });
    }
  }, 5000);

  const headerButtonsStyle = {
    'margin-left': '435px'
  };

  const headerIconsStyle = {
    height: '30px',
    weight: '30px',
  };

  const IconButtonStyle = {
    'margin-left': '50px',
    'margin-right': '50px'
  }

  var headerMenu = '';
  if (localStorage.getItem('access_token')) {
    headerMenu = (
      <>
        <div className="headerButtons" style={headerButtonsStyle}>
        <IconButton onClick={() => navigate('/notifications')} style={IconButtonStyle}><Badge badgeContent={unreadNotificationsCount} color="primary"><img src={notice} style={headerIconsStyle}></img></Badge></IconButton>
        <IconButton onClick={() => navigate('/history')} style={IconButtonStyle}><img src={match} style={headerIconsStyle}></img></IconButton>
        <IconButton onClick={() => navigate('/directMessage')} style={IconButtonStyle}><Badge badgeContent={unreadMessagesCount} color="primary"><img src={message} style={headerIconsStyle}></img></Badge></IconButton>
        <IconButton style={IconButtonStyle}><img src={album} style={headerIconsStyle}></img></IconButton>
        </div>
      </>
    );
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
        <img src={Logo} alt="picture" onClick={() => navigate('/')} style={{cursor: "pointer"}}/>
          <Typography variant="h6" component="div" sx={{ flexGrow: 1 }}>
          {headerMenu}
          </Typography>
          {AuthMenu}
        </Toolbar>
      </AppBar>
      {renderMenu()}
    </Box>
  );
};

export default HomeBar;