import { useNavigate } from "react-router-dom";
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

  return (
    <AppBar position="static">
      <Toolbar>
        <Typography variant="h6" component="div" sx={{ flexGrow: 1 }}>
          News
        </Typography>
        <Button color="inherit" onClick={() => goToAccountPage()}>
          Login
        </Button>
      </Toolbar>
    </AppBar>
  );
};

export default HomeBar;