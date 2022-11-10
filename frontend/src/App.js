import {
  BrowserRouter,
  Routes,
  Route,
  Outlet,
  Link,
  useLocation
} from "react-router-dom";
import HomeBar from "./HomeBar";
import Login from "./components/pages/login/Login";
import Signup from "./components/pages/signup/Signup";

const Links = () => {
  // リンクによるページ遷移
  return (
    <ul>
      <li>
        <Link to="/link1">Link 1</Link>
      </li>
      <li>
        <Link to="/link2">Link 2</Link>
      </li>
    </ul>
  );
};

const Link1 = () => <h2>This is a page of Link1.</h2>;
const Link2 = () => <h2>This is a page of Link2.</h2>;

const Menu = () => {
  let location = useLocation();
  return (
    <>
      <HomeBar />
      {/* これは今開いているページによって表示するコンポーネントを変えている */}
      {/* location.pathname で今開いているページのパスを取得できる */}
      {location.pathname === "/" ? <Links /> : <></>}
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
          <Route path="/link1" element={<Link1 />} />
          <Route path="/link2" element={<Link2 />} />
          <Route path="/login" element={<Login />} />
          <Route path="/signup" element={<Signup />} />
        </Route>
      </Routes>
    </BrowserRouter>
  );
};

export default App;