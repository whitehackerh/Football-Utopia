import {
  BrowserRouter,
  Routes,
  Route,
  Outlet,
  Link,
  useLocation
} from "react-router-dom";
import Home from "./components/pages/home/Home";
import HomeBar from "./HomeBar";
import Login from "./components/pages/login/Login";
import Signup from "./components/pages/signup/Signup";
import User from "./components/pages/user/User";
import BasicProfileSettings from "./components/pages/accountSettings/BasicProfileSettings";
import ProfilePictureSettings from "./components/pages/accountSettings/ProfilePictureSettings";
import DetailProfileSettings from "./components/pages/accountSettings/DetailProfileSettings";
import FilterSettings from "./components/pages/accountSettings/FilterSettings";
import History from "./components/pages/match/History";
import Match from "./components/pages/match/Match";

const Top = () => {
  // リンクによるページ遷移
  return (
    <h1></h1>
  );
};


const Menu = () => {
  let location = useLocation();
  return (
    <>
      <HomeBar />
      {/* これは今開いているページによって表示するコンポーネントを変えている */}
      {/* location.pathname で今開いているページのパスを取得できる */}
      {location.pathname === "/" ? <Top /> : <></>}
      <Outlet />
    </>
  );
};

const App = () => {
  return (
    <BrowserRouter>
      <Routes>
        {/* ネストさせる(Route 要素の中に Route 要素を入れる)ことで、常に表示させたいコンポーネントを維持することができる */}
        <Route path="/" element={<Menu />}>
          {/* パスによってどのコンポーネントをレンダーするか決める */}
          <Route path="/home" element={<Home />} />
          <Route path="/login" element={<Login />} />
          <Route path="/signup" element={<Signup />} />
          <Route path="/user" element={<User />} />
          <Route path="/basicProfileSettings" element={<BasicProfileSettings />} />
          <Route path="/profilePictureSettings" element={<ProfilePictureSettings />} />
          <Route path="/detailProfileSettings" element={<DetailProfileSettings />} />
          <Route path="/filterSettings" element={<FilterSettings />} />
          <Route path="/history" element={<History />} />
          <Route path="/match" element={<Match />} />
        </Route>
      </Routes>
    </BrowserRouter>
  );
};

export default App;